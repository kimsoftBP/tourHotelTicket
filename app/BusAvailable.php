<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BusAvailable extends Model
{
    protected $table="bus_available";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'busid','date','from_time','to_time','to_date','bus_available_typeid',
        'remove','remove_date','city','days',
        'created_at','updated_at',
        ];
    public function bus(){
        return $this->hasOne('App\Bus','id','busid');
    }
    public function available(){
        return $this->hasOne('App\BusAvailableType','id','bus_available_typeid');
    }
    public function diff($date){
        $fdate=Carbon::createFromDate($date);
        $todate=Carbon::createFromDate($this->to_date);
        $diff=$todate->diffInDays($fdate);
        return $diff;
    }
}
