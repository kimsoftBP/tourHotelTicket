<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Continent;

class RegionController extends Controller
{
    //
    public function index(){
    	$data['continent']=Continent::get();
    	return view('region')->with('data',$data);
    }
}
