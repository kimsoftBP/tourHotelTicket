<?php

namespace App;

use App\Notifications\CustomVerifyEmail;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;



class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    //    ...Your Logic Here
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'email', 'password','phonenumber','countryid','cityid','city','company_name','postcode','address','tax_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
/*
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail); // my notification
    }*/


    public function permadminmenu(){
        $perm=Permission::where('userid',$this->id)
            ->whereHas('permissionName',function(Builder $query){
                $query->whereRaw('perm_name like "admin"')
                    ->orWhere('perm_name','continent admin')
                    ->orWhere('perm_name','moderator');
            })
            ->get();
        if($perm==NULL || count($perm)==0){
            return false;
        }
        return true;
    }
    public function permadmin(){                
        $perm=Permission::where('userid',$this->id)
            ->whereHas('permissionName',function(Builder $query){
                $query->whereRaw('perm_name like "admin"');
            })
            ->get();
        if($perm==NULL || count($perm)==0){
            return false;
        }
        return true;
    }


    /***
     * bus
     * */
    public function permPartnerBus(){
        $perm=Permission::where('userid',$this->id)
            ->whereHas('permissionName',function(Builder $query){
                $query->whereRaw('perm_name like "partner bus"');
            })
            ->get();
        if($perm==NULL || count($perm)==0){
            return false;
        }
        return true;
    }
    /****
     * this perm tour and ticket
     * ***/
    public function permPartnerTicketOrTour(){
        $perm=Permission::where('userid',$this->id)
            ->whereHas('permissionName',function(Builder $query){
                $query->whereRaw('perm_name like "partner tour/ticket"');
                //$query->whereRaw('perm_name like "partner%"');
            })->get();
        if($perm==NULL || count($perm)==0){
            return false;
        }
        return true;
    }
    /***
     * 
     * **/
    public function permpartner(){
        $perm=Permission::where('userid',$this->id)
            ->whereHas('permissionName',function(Builder $query){
                $query->whereRaw('perm_name like "partner%"');
            })
            ->get();
        if($perm==NULL || count($perm)==0){
            return false;
        }
        return true;
    }

    public function permcontinentadmin(){
        $perm=Permission::where('userid',$this->id)
            ->whereHas('permissionName',function(Builder $query){
                $query->whereRaw('perm_name like "continent admin"');
            })
            ->get();
        if($perm==NULL || count($perm)==0){
            return false;
        }
        return true;      
    }
    public function permmoderator(){
        $perm=Permission::where('userid',$this->id)
            ->whereHas('permissionName',function(Builder $query){
                $query->whereRaw('perm_name like "moderator"');
            })
            ->get();
        if($perm==NULL || count($perm)==0){
            return false;
        }
        return true;   
    }


    public function permnotneedconfirmation(){
        $perm=Permission::where('userid',$this->id)
            ->whereHas('permissionName',function(Builder $query){
                $query->whereRaw('perm_name like "not_need_confirmation"');
            })
            ->get();
        if($perm==NULL || count($perm)==0){
            return false;
        }
        return true;   
    }


    public function permission(){
        return $this->hasMany('App\Permission','userid','id');
    }
    public function permissionRegion(){
        return $this->hasMany('App\PermissionRegion','userid','id');
    }
    public function permissionLanguage(){
        return $this->hasMany('App\PermissionLanguage','userid','id');
    }
    public function product(){
        return $this->hasMany('App\Product','userid','id');
    }
    public function spoke(){
        return $this->hasMany('App\UserSpoken','userid','id');
    }
    public function country(){
        return $this->hasOne('App\Country','id','countryid');
    }
    public function getcity(){
        return $this->hasOne('App\City','id','cityid');
    }

    public function BusPermission(){
        return $this->hasMany('App\BusCompanyPermission','userid','id');
    }
    public function BusCompany(){
        //return $this->hasMany('App\BusCompany','id','')

/*
** Problem sometime not return data

        return $this->hasManyThrough(
            'App\BusCompany',
            'App\BusCompanyPermission',
            'bus_companyid',//foreign key on BusCompanyPermission table
            'id',//Foreign key on BusCompany table 
            'id',//Local Key on Users table
            'userid',//Local Key on BusCompanyPermission table
            );
        */
    }
    /***
     * 
     * 
     return $this->hasManyThrough(
            Deployment::class,
            Environment::class,
            'project_id', // Foreign key on the environments table...
            'environment_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
     * **/
}
