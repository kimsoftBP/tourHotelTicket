<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Reservation;
use App\ReservationPay;
use App\PayLog;
use App\Transaction;
use App\Paymethod;

/*

use App\Pay;
use App\Paylog;
use App\Transaction;
use App\Order;
use App\Orderproducts;
use App\Shippingtype;
use App\Config;
use App\Exchangerate;
use Exception;

use App\Jobs\SendTourmail;

*/
use App\Jobs\SendCustomerFaildpay;
use App\Jobs\SendCustomerSuccesspay;
use App\Jobs\SendPartnerReservationEmail;

class PayCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 
     public $timeout=120;
    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       // Log::debug('handle');
       // try {

            $sumupconf=Paymethod::where('id',$this->details['paymethodid'])->first();


            $sumup = new \SumUp\SumUp([
                    'app_id'=> $sumupconf->client_id,
                    'app_secret'=> $sumupconf->client_secret,
                    /*'app_id'     => env('Sumup_client_id', 'Sumup'),
                    'app_secret' => env('Sumup_client_secret', 'Sumup'),*/
                    'grant_type' => 'client_credentials',
            ]);
            $accessToken = $sumup->getAccessToken();
            $value = $accessToken->getValue();
            $type=$accessToken->getType();
            $expires=$accessToken->getExpiresIn();
            $checkoutsService = $sumup->getCheckoutService();

            // status PENDING, FAILED, PAID, maybe expire
            
           
           

            $checkoutid=$this->details['checkoutid'];
/*
            $exc=Exchangerate::where('currency','won')->orderBy('created_at','desc')->first();
            $won=$exc->value;    
            $won=100/$won;
         
            if($checkoutid==0){
                //

               }*/
            $checkpay=$checkoutid;
            //
            //$checkpay="cfefdc63-e95e-4dd9-b0b4-3a3fff591f35";
            $resp=$checkoutsService->findById($checkpay);

            //$code=$resp->httpResponseCode;
            $status=$resp->getBody()->status;
            if($status=="FAILED"){

            }elseif($status=="PAID"){

            }
            $now=now();
            $transactioncode="";
            foreach ($resp->getBody()->transactions as $transaction) {
                //echo $transaction->status;
               // echo $transaction->id."\n";
                //echo $transaction->timestamp."\n";
                $transactioncode=$transaction->transaction_code;
                $trans=\App\Transaction::updateOrCreate(
                    ['transaction_id'=>$transaction->id],
                    ['transaction_code'=>$transaction->transaction_code,
                    'checkoutid'=>$checkoutid,
                    'merchant_code'=>$transaction->merchant_code,
                    'amount'=>$transaction->amount,
                    'vat_amount'=>$transaction->vat_amount,
                    'tip_amount'=>$transaction->tip_amount,
                    'currency'=>$transaction->currency,
                    'timestamp'=>$transaction->timestamp,
                    'status'=>$transaction->status,
                    'payment_type'=>$transaction->payment_type,
                    'entry_mode'=>$transaction->entry_mode,
                    'installments_count'=>$transaction->installments_count,
                    'internal_id'=>$transaction->internal_id,
                    'updated_at'=>$now,

                    ]
                    );
            }
            $pay=ReservationPay::where('checkoutid',$checkoutid)->first();
            $pay->status=$status;
            $pay->updated_at=now();
            $pay->save();
            //$res=Reservation::where('id',$pay->reservationid)->first();
            if(env('APP_NAME')=="Dev-tourguide"){
                $status="PAID";
            }

            $paylog=new PayLog;            
            $paylog->checkoutid=$pay->checkoutid;
            $paylog->checkoutRef=$pay->checkoutref;
            $paylog->status=$status;
            $paylog->save();
        
            $respay=ReservationPay::where('id',$this->details['reservationpayid'])->first();
            $reservation=$respay->reservation;
            $reservation->paystatus=$status;
            $reservation->save();
            $user=$reservation->user;
/*
            $order=Order::where('id',$pay->offersid)->first();
            $order->paystatus=$status;
            $order->save();

            $user=DB::table('users')->where('id',$order->userid)->first();
            $bp=Orderproducts::where('orderid',$order->id)->get();*/

            //$shipping=Shippingtype::first();
            //$text="<table><tr><td>h</td><td>3</td></tr><tr><td>row</td></tr></table>";

            //$currency=Config::where('name','currency')->first();

            $details = [
                'customeremail' => $user->email,
                'email'=>$user->email,
                'name'=>$user->name,
                'reservation'=>$reservation,
                /*'phonenumber'=>$user->phonenumber,
                'city'=>$user->city,
                'address'=>$user->address,
                'text'=>$text,
                'bp'=>$bp,
                'currencyhtml'=>$currency->html,
                'shippingname'=>$shipping->name,
                'shippingprice'=>$shipping->price,
                'offertoken'=>$order->ordertoken,*/
                'paystatus'=>$status,
                'token2'=>$reservation->token2,
                'paymethod'=>'sumup',
                'transactioncode'=>$transactioncode,
                'locale'=>$this->details['locale'],
                //'won'=>$won,
            ];
            $details2=$details;
            $details2['email']=$reservation->product->user->email;


            // status PENDING, FAILED, PAID, maybe expire            
            switch ($status) {
                case 'PAID':
                    SendCustomerSuccesspay::dispatch($details);
                    SendPartnerReservationEmail::dispatch($details2);
                    $details2['email']="sales@kimsoft.at";
                    SendPartnerReservationEmail::dispatch($details2);


                /*
                    SendCustomermail::dispatch($details);
                    SendTourmail::dispatch($details);
                    */
                    break;
                case 'FAILED':
                    SendCustomerFaildpay::dispatch($details);
                    break;
                case 'EXPIRE':
                    SendCustomerFaildpay::dispatch($details);
                    break;
                case 'PENDING':
                    $delay = 60 * 10;
                    $this->release($delay);
           
                    break;
                default:
                    
                    break;
            }
    }
    public function failed($exception){
        $exception->getMessage();
    }
}
