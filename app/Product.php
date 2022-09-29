<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
   	protected $table="product";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','countryid','cityid','categoryid','title','onelinesummary','introduction','toursizeid','minimumnumberofdepartures','availableto','meetingdate','meetingtime','meetingplacename','meetingplacecoordinate','totalrequiredday','totalrequiredminute','totalrequiredhour','priceincluded','notincluded','essentialguidance','userid','vehicleid','created_at','updated_at','page1','page2','page3','checkadmin','nocity','photorights','pricetypeid','additionalairarrival','additionalflightdeparture','additionalhotel',
        'admin_check_message','remove','meta_title','meta_description',
    ];
    public function country(){
      	return $this->hasOne('App\Country','id','countryid');
    }
    public function city(){
      	return $this->hasOne('App\City','id','cityid');
    }  
    public function category(){
      	return $this->hasOne('App\Category','id','categoryid');
    }
    public function toursize(){
    	return $this->hasOne('App\TourSize','id','toursizeid');
    }
    public function user(){
    	return $this->hasOne('App\User','id','userid');
    }
    public function vehicle(){
    	return $this->hasOne('App\Vehicle','id','vehicleid');
    }
    public function pricetype(){
      return $this->hasOne('App\PriceType','id','pricetypeid');
    }

	public function language(){
		return $this->hasMany('App\ProductLanguage','productid','id');
	}    
	public function photo(){
		return $this->hasMany('App\ProductPhoto','productid','id');
	}
	public function meetingphoto(){
		return $this->hasMany('App\ProductMeetingPhoto','productid','id');
	}
	public function subcategory(){
		return $this->hasMany('App\ProductSubcategory','productid','id');
	}
  public function tourcourse(){
    return $this->hasMany('App\TourCourse','productid','id');
  }
  public function tourcoursechange(){
    $perm=TourCourse::where('productid',$this->id)
    ->whereHas('log',function(Builder $query){
        $query->whereNull('confirmbyuserid');
    })
    ->get();
    if($perm==NULL || count($perm)==0){
        return false;
    }
    return true;   
    /*
    return $this->tourcourse->whereHas('log',function($query){
      $query->whereNull('confirmbyuserid');
    });*/
    //return $this->hasMany('App\TourCourseChangeLogConfirm','')
  }


  public function price(){
    return $this->hasMany('App\ProductPrice','productid','id')->orderBy('person');
  }
  public function priceorderbymaximumpeople(){
    return $this->hasMany('App\ProductPrice','productid','id')->orderBy('maximumpeople','DESC');
  }
  public function priceorderbyminimumpeople(){
    return $this->hasMany('App\ProductPrice','productid','id')->orderBy('maximumpeople');
  }

  public function ticket(){
    return $this->hasMany('App\ProductTicket','productid','id');
  }
  public function feedback(){
    return $this->hasMany('App\Feedback','productid','id');
  }
  public function avgfeedback(){
    return $this->feedback()->average('star');    
  }
  public function feedbackstat(){    
    /*
    return $this->hasOne('App\Feedback','productid','id')->selectRaw('COUNT(id) as num,AVG(star) as avgstar')->groupBy('productid'); */

    $avg=Feedback::selectRaw('COUNT(id) as num,AVG(star) as avgstar')->where('productid',$this->id)->groupBy('productid')->first();    
   // $data[0]=$avg->num;
    return $avg;
  }
  public function confirmlog(){
    return $this->hasMany('App\ProductChangeConfirmation','productid','id');
  }

  public function confirmmessage(){
    return $this->hasMany('App\Message','productid','id')->whereHas('type',function($query){
          $query->where('name','confirmation');
      })->orderBy('created_at','DESC');
  }
  public function confirmmessageASC(){
    return $this->hasMany('App\Message','productid','id')->whereHas('type',function($query){
          $query->where('name','confirmation');
      })->orderBy('created_at')->limit(5);
  }
  public function reservation(){
    return $this->hasMany('App\Reservation','productid','id');
  }
  public function available(){
    return $this->hasMany('App\ProductAvailable','productid','id')->orderBy('date');
  }
  public function availableAfterToday(){
    return $this->hasMany('App\ProductAvailable','productid','id')->where('date','>',now())->orderBy('date')->orderBy('hour','ASC');
  }
  public function availableUi(){
    return $this->hasMany('App\ProductAvailableUi','productid','id');
  }
}
