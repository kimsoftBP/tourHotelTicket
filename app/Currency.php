<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exchangerate;

class Currency extends Model
{
    protected $table="currency";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','html','code','created_at','updated_at'
    ];


    public function exchangerate(){
    	$date=date("Y-m-d");
        $soap_params = array(
         'soap_version' => 'SOAP_1_1',
         'trace' => 1,
        );
        $soapClient = new \Soapclient("http://www.mnb.hu/arfolyamok.asmx?singleWsdl", $soap_params);
        $result = $soapClient->GetExchangeRates(array('startDate' => $date, 'endDate' => $date, 'currencyNames' => $this->code));
        if($this->code=="HUF"){
            /*
            $data['rate']=1;
            $data['unit']=1;
            */
             //return $data;
           return ['rate'=>1,'unit'=>1]; 
        }

        $rate=$result->GetExchangeRatesResult;        
        $rate=strip_tags($rate);
        $rate=str_replace(",",".",$rate);
        $rate=round($rate,2);

        //not have today rate date get yesterday
        if($rate==NULL || $rate==0){
	        $date2=date('Y-m-d',strtotime('-1 days'));        
	        $result = $soapClient->GetExchangeRates(array('startDate' => $date2, 'endDate' => $date2, 'currencyNames' => $this->code));
	        $rate=$result->GetExchangeRatesResult;
    	}
                
        $unit=1;
        if($this->code=="KRW" || $this->code=="IDR" || $this->code=="JPY"){
        	$unit=100;
        }
        //if today and yesterday data null load last data
        if($rate==NULL || $rate ==0 ){
           $exc=Exchangerate::where('currency',$this->code)->orderBy('created_at','desc')->first();
            $rate=$exc->value;
        }else{
        	$exchangerate=Exchangerate::create(['currency'=>$this->code,'value'=>$rate,'unit'=>$unit,'to'=>'HUF']);
        }
        $data['rate']=$rate;
        $data['unit']=$unit;
        return $data;
    }
}
