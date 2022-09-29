<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Continent;
use App\Region;

class AjaxController extends Controller
{
    //
    public function ajaxregion(Request $req) {
        $id=$req->id;
        $msg="<option value=''>Choose..</option>";
 //         $msg="<option value''>".$id."</option>";
        $continent=Continent::where('name',$id)->first();
        foreach ($continent->regions as $region) {
            $msg.="<option value='".$region->name."'>".$region->name."</option>";   
        }
        //$msg.="<option value='".$crow->id."'>".$crow->namehu."</option>";
        
        return response()->json(array('msg'=> $msg), 200);
   }
   public function ajaxcountry(Request $req){
      $id=$req->id;
      $msg="<option value=''></option>";
      $region=Region::where('name',$id)->first();
      foreach ($region->country as $country) {
        $msg.="<option value='".$country->name."'>".$country->name."</option>";
      }      
      return response()->json(array('msg'=> $msg), 200);
   }
}
