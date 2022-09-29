<?php

namespace App\Http\Controllers\Paymethods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Reservation;
use App\ReservationPay;
use App\Paymethod;
use App\Currency;
use App\Jobs\PayCheck;

class PaymethodsController extends Controller
{
    //
    public function token(){
        $i=1;
        $token=NULL;
        while ($i==1) {
            $token=md5(rand(1, 10) . microtime());
            $t=Reservation::where('token',$token)->first();
            if($t==NULL){$i=0;}
        }
        return $token;
    }
    public function token2(){
        $i=1;
        $token2=NULL;
        while ($i==1) {
            $token2=rand(100000,900000);            
            $t=Reservation::where('token2',$token2)->first();
            if($t==NULL){$i=0;}
        }

        return $token2;
        
    }


    public function index(Request $req){
        $validateDate=$req->validate([
            'resrvation'=>'required|exists:reservation,id',
            'paymethod'=>'required|exists:paymethod,id'
            ]);
        $reservation=Reservation::where('id',$req->resrvation)->first();

        $reservation->token=$this->token();
        $reservation->token2=$this->token2();
        $reservation->save();
        $paymethod=Paymethod::where('id',$req->paymethod)->first();
        if($paymethod->name="Sumup"){
            return $this->sumup($reservation->id,$reservation->sumprice,$reservation->token,$req->paymethod);
        }

        //$token=md5(rand(1, 10) . microtime());
    }



    public function sumup($reservationid,$price,$token,$paymethodid){
        $res=Reservation::where('id',$reservationid)->first();
//        $currency=$res->currency;
        $rate=$res->currency->exchangerate();

        $showoriginprice=$price." ".$res->currency->html;
        $price=$price*$rate['rate']/$rate['unit'];

        /*
        $exc=Exchangerate::where('currency','won')->orderBy('created_at','desc')->first();
        $won=$exc->value;    
        $won=100/$won;
        $currency=Config::where('name','currency')->first();
        if($currency->code=="HUF"){
            $price=round($price,0);
        }*/

        $price=round($price,0);


        $sumupconf=Paymethod::where('id',$paymethodid)->first();
        $currency=Currency::where('code',$sumupconf->currencycode)->first();
        

        $checkoutid=0;
        $error=0;

        $checkpays=ReservationPay::where('reservationid',$reservationid)
            ->orderBy('created_at','desc')
            ->first();
        /*
        $checkpays=Pay::where('offersid', 'like',$offersid)
                ->orderBy('created_at','desc')
                ->first();*/

        if($checkpays!=NULL && ( $checkpays->status!='PENDING' || $checkpays->status!='create') ){
           // return view('pay.pending');
        }


        try {
            $sumup = new \SumUp\SumUp([
                    'app_id'=> $sumupconf->client_id,
                   // 'app_id'     => env('Sumup_client_id', 'Sumup'),
                    //'app_secret' => env('Sumup_client_secret', 'Sumup'),
                    'app_secret'=> $sumupconf->client_secret,
                    'grant_type' => 'client_credentials',
                ]);
            $accessToken = $sumup->getAccessToken();
            $value = $accessToken->getValue();
            $type=$accessToken->getType();
            $expires=$accessToken->getExpiresIn();    
            
            $checkoutRef=$token;
            //$paytoemail=env('Sumup_email', 'Sumup');
            $paytoemail=$sumupconf->email;
            $appname=config('app.name');
            $checkoutsService = $sumup->getCheckoutService();
            $response = $checkoutsService->create($price, 'HUF', $checkoutRef, $paytoemail,  $appname);
            $checkoutid = $response->getBody()->id;
           /* echo "sumup debug <br>";
            if(isset($response->getBody()->error_code )){
                echo $response->getBody()->error_code;
            }*/
            
        } catch (\SumUp\Exceptions\SumUpAuthenticationException $e) {
            echo 'Authentication error: ' . $e->getMessage();
            $error=1;
        } catch (\SumUp\Exceptions\SumUpResponseException $e) {
            echo 'Response error: ' . $e->getMessage().'  '.$e->getCode();
            $error=1;
        } catch(\SumUp\Exceptions\SumUpSDKException $e) {
            echo 'SumUp SDK error: ' . $e->getMessage();
            $error=1;
        }
        //if($checkoutid!=0){

        $pay=ReservationPay::create([
            'reservationid'=>$reservationid,
            'paymethodid'=>$paymethodid,
            'checkoutid'=>$checkoutid,
            'checkoutref'=>$checkoutRef,
            'status'=>'create',
            'amount'=>$price,
            ]);
        /*
            $pay=Pay::create([
                'checkoutid'=>$checkoutid,
                'checkoutref'=>$checkoutRef,
                'offersid'=>$offersid,
                'status'=>'create',
                ]);
*/

          //  print_r($pay);
            
            $checkdetails = [
                'checkoutid' => $checkoutid,
                'paymethodid'=>$paymethodid,
                'reservationpayid'=>$pay->id,
                'locale'=>app()->getLocale(),
            ];
            PayCheck::dispatch($checkdetails)->delay(now()->addMinutes(5));
        //}else{
         //   echo "no checkout id<br>";
        //    print_r($checkoutid);
            //return redirect(404);
        //}

        
//hu-HU
        //en-US
        $sumuplang="en-US";
        if( app()->getLocale()=="hu" ){            
            $sumuplang="hu-HU";
        }
        
        return view('pay.sumup')->with('checkoutId',$checkoutid)->with('error',$error)->with('price',$price)->with('currency',$currency)->with('sumuplang',$sumuplang)->with('showoriginprice',$showoriginprice)
            //->with('won',$won)
            ;
    }
    public function fullrefundsumup(Reservation $reservation){
        $checkoutid="";

        $transactionsService = $sumup->getTransactionService();
        $response = $transactionsService->refund($checkoutid);
        //The response returns a 204 HTTP status code and contains no body.
    }
    public function refundsumup(){
        $checkoutid="";
        $refundamount="1";

        $transactionsService = $sumup->getCheckoutService();
        $response = $transactionsService->refund($checkoutid, $refundamount);
    }
}
