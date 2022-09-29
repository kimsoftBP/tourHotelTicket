<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductAvailableUi extends Model
{
    //
    protected $table="product_available_ui";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'productid',
        'to_date','from_date','hour',
        'monday','tuesday','wednesday','thursday','friday','saturday','sunday',
        'created_at','updated_at',
        ];
    public function product(){
        return $this->hasOne('App\Product','id','productid');
    }
    public function available(){
        return $this->hasMany('App\ProductAvailable','available_uiid','id')->orderBy('date','ASC');
    }
    public function availableAfterToday(){
        return $this->hasMany('App\ProductAvailable','available_uiid','id')->where('date','>',now()->format('Y-m-d'))->orderBy('date','ASC');
    }

    /***  ***/
    public function availableAfterTodayHaveTicket(){
        return ProductAvailable::where('available_uiid',$this->id)->where('date','>',now()->format('Y-m-d'))
            ->whereHas('ticketavailable',function($query){
                $query->where('piece','>',0);
            })
            ->orderBy('date')
            ->get();
    }
    public function availableHours($date){
        return ProductAvailable::where('available_uiid','LIKE',$this->id)
            ->where('date','>',$date)
            ->whereHas('ticketavailable',function($query){
                $query->where('piece','>',0);
            })
            ->orderBy('hour')
            ->get();
    }
}
