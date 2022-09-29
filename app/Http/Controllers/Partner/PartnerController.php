<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\City;
use App\Country;
use App\Currency;
use App\Region;
use App\Vehicle;
use App\TourSize;
use App\Language;
use App\Product;
use App\ProductLanguage;
use App\ProductMeetingPhoto;
use App\ProductPhoto;
use App\ProductChangeConfirmation;
use App\ProductPrice;
use App\PriceType;
use App\ProductSubcategory;
use App\ProductTicket;
use App\ProductTicketChange;
use App\ProductTicketAvailable;
use App\ProductTicketAvailablePiece;
use App\ProductAvailable;
use App\ProductAvailableUi;
use App\TourCourse;
use App\TourCourseChangeLogConfirm;
use App\TourCoursePhoto;
use App\Message;
use App\MessageType;
use App\Photo;
use App\Reservation;
use Validator;
use Response;
use Auth;

use File;
use Intervention\Image\ImageManagerStatic as Image;
use ImageOptimizer;
use Carbon\Carbon;

class PartnerController extends Controller
{
	public function index(){		
		return view('partner.view');
	}
    public function product(){
      /*
    	$data['country']=Country::get();
        $data['category']=Category::get();
        $data['toursize']=TourSize::get();
        $data['vehicle']=Vehicle::get();
        $data['language']=Language::get();
        $data['subcategory']=[];*/
      $user=Auth::user();
      $data['products']=Product::where('userid',$user->id)
          ->where('remove',0)
          ->get();
   //     $data['subcategory']=SubCategory::groupBy('name')->get();
    	return view('partner.product')->with('data',$data);
    }



    public function addproduct(){
      $user=Auth::user();
      $newproduct=Product::create(['userid'=>$user->id]);
      return redirect(route('partner.product.editpage1',['locale'=>app()->getLocale(),'product'=>$newproduct->id]));

        $data['country']=Country::orderBy('name')->get();
        $data['category']=Category::get();
        $data['toursize']=TourSize::get();
        $data['toursizegroup']=TourSize::where('name','Group tour')->first();
        $data['vehicle']=Vehicle::get();
        $data['language']=Language::get();
        $data['subcategory']=[];
        $data['subcategory']=SubCategory::orderBy('name')->groupBy('name')->get();
      return view('partner.addproduct')->with('data',$data);
    }



    public function  addproductpost(Request $req){


      $validateDate=$req->validate([
        'country'=>'required|exists:country,name',
        'city'=>'nullable|exists:city,name',
        'nocity'=>'required_without:city',
        'category'=>'required|exists:category,name',
        'language'=>'required',
        //subcategory
        'subcategory'=>'required|min:1',
        'SubCategory.*'=>'exists:sub_category,id',
        'title'=>'required|unique:product,title|max:250',
        'onelinesummary'=>'required|string|max:490',
        'travelintroduction'=>'required|string|max:3000',
        'toursize'=>'required|exists:tour_size,id',              
        'vehicle'=>'required|exists:product_vehicle,id', 
        'minimumnumberofdepartures'=>'nullable|integer|min:0',
        'photo'=>'',
        'photo.*'=>'',
        'havephotorights'=>'required',
        'meetingtime'=>'required',
        'nameofmeetingplace'=>'required|string|max:250',
        'meetingplacelocation'=>'nullable|string|max:250',

        'meetingplacephoto'=>'',

        //tour course....
        'tcoursetitle.*'=>'required|string|max:250',
        'tcoursehour.*'=>'required|integer|min:0',
        'tcourseminute.*'=>'required|integer|min:0|max:60',
        'tcoursecontent.*'=>'string|max:3000',


        'totalreqday'=>'integer|min:0',
        'totalreqhour'=>'integer|min:0|max:24',
        'totalreqmin'=>'integer|min:0',

        'priceincluded'=>'string|max:2000',
        'pricenotincluded'=>'nullable|string|max:2000',
        'essentialguidance'=>'nullable|string|max:2000',
        ]);
      
/*
  meetingtime check and time
  or check and input box
      Coordination after confirmation of reservation
-*/
        $user=Auth::user();
        $country=Country::where('name',$req->country)->first();        
        $city=City::where('name',$req->city)->where('countryid',$country->id)->first();
        $cityid=NULL;
        $category=Category::where('name',$req->category)->first();
        if($city!=NULL){
          $cityid=$city->id;
        }
        $product=Product::create([
          'countryid'=>$country->id,
          'cityid'=>$cityid,
          'categoryid'=>$category->id,
          'title'=>$req->title,
          'onelinesummary'=>$req->onelinesummary,
          'introduction'=>$req->travelintroduction,
          'toursizeid'=>$req->toursize,
          'minimumnumberofdepartures'=>$req->minimumnumberofdepartures,
          /*not used
          //'availableto'=>
          //'meetingdate'=>
          */
          'meetingtime'=>$req->meetingtime,
          'meetingplacename'=>$req->nameofmeetingplace,
          'meetingplacecoordinate'=>$req->meetingplacelocation,
          'totalrequiredday'=>$req->totalreqday,
          'totalrequiredhour'=>$req->totalreqhour,
          'totalrequiredminute'=>$req->totalreqmin,
          /*'priceincluded'=>
          'notincluded'=>
          'essentialguidance'=>*/
          'userid'=>$user->id,
          'vehicleid'=>$req->vehicle,
            ]);        
        foreach ($req->language as $language) {
          ProductLanguage::create([
              'languageid'=>$language,
              'productid'=>$product->id]);
        }
        foreach ($req->subcategory as $subcategory) {
          
        }
        $k=count($req->tcoursetitle);
        for($i=0;$i<$k;$i++){
            TourCourse::create([
              'title'=>$tcoursetitle[$i],
              'content'=>$tcoursecontent[$i],
              'hour'=>$req->tcoursehour[$i],
              'minute'=>$req->tcourseminute[$i],
              'productid'=>$product->id,
            ]);
        }

  //      print_r($req->language);//Array ( [0] => 2 [1] => 4 )        
    }
    public function editpage1(Request $req){      
      $validator = Validator::make($req->all(), [
        'product'=>'required|exists:product,id',        
      ]);
      if ($validator->fails()) {
          return redirect(404);            
      }      
      $user=Auth::user();
      $data['product']=Product::where('id',$req->product)->where('userid',$user->id)->first();
      if($data['product']==NULL){
        return redirect(404);
      }
      $data['productlanguagearray']=[];
      $data['productsubcategoryarray']=[];      
      foreach ($data['product']->language as $language) {        
        array_push($data['productlanguagearray'], $language->languageid);
      }
      foreach ($data['product']->subcategory as $subcategory) {        
        array_push($data['productsubcategoryarray'],$subcategory->subcategoryid);
      }
      $data['city']=City::where('countryid',$data['product']->countryid);
      $data['productcity']="";
      if($data['product']->cityid!=NULL){
        $data['productcity']=$data['product']->city->name;
      }
      $data['country']=Country::orderBy('name')->get();
      $data['category']=Category::get();
      $data['toursize']=TourSize::get();
      $data['toursizegroup']=TourSize::where('name','Group tour')->first();
      $data['vehicle']=Vehicle::get();
      $data['language']=Language::get();
      $data['subcategory']=[];
      $data['subcategory']=SubCategory::orderBy('name')->groupBy('name')->get();
      return view('partner.editpage1')->with('data',$data);
    }
    public function editpage2(Request $req){
            $validator = Validator::make($req->all(), [
        'product'=>'required|exists:product,id',        
      ]);
      if ($validator->fails()) {
          return redirect(404);            
      }      
      $user=Auth::user();
      $data['product']=Product::where('id',$req->product)->where('userid',$user->id)->first();
      if($data['product']==NULL){
        return redirect(404);
      }

      $data['productlanguagearray']=[];
      //print_r($data['product']->language);
      foreach ($data['product']->language as $language) {        
        array_push($data['productlanguagearray'], $language->languageid);
      }
      $data['country']=Country::orderBy('name')->get();
      $data['category']=Category::get();
      $data['toursize']=TourSize::get();
      $data['toursizegroup']=TourSize::where('name','Group tour')->first();
      $data['vehicle']=Vehicle::get();
      $data['language']=Language::get();
      $data['subcategory']=[];
      $data['subcategory']=SubCategory::orderBy('name')->groupBy('name')->get();
      return view('partner.editpage2')->with('data',$data);
    }
    public function editpage3(Request $req){
      $validator = Validator::make($req->all(), [
              'product'=>'required|exists:product,id',        
      ]);
      if ($validator->fails()) {
          return redirect(404);            
      }      
      $user=Auth::user();
      $data['currency']=Currency::get();
      $data['product']=Product::where('id',$req->product)->where('userid',$user->id)->first();
      if($data['product']==NULL){
        return redirect(404);
      }
      return view('partner.editpage3')->with('data',$data);
    }

    public function posteditpage1(Request $req){
      $validateDate=$req->validate([
        'product'=>'required|exists:product,id',
        'country'=>'required|exists:country,name',
        'city'=>'nullable|exists:city,name',
        'nocity'=>'required_without:city',
        'category'=>'required|exists:category,name',
        'language'=>'required',
        //subcategory
        'photos'=>'',
        'photos.*'=>'nullable|image|mimes:jpeg,jpg,png,gif,bmp',
        'subcategory'=>'required|min:1',
        'SubCategory.*'=>'exists:sub_category,id',
        //'title'=>'required|max:250',
        //'title'=>Rule::unique('product')->ignore($req->product),
        'title'=>'required|max:250|not_regex:/[\/,%]/i|unique:product,title,'.$req->product,

        'onelinesummary'=>'required|string|max:490',
        'travelintroduction'=>'required|string|max:3000',
        'toursize'=>'required|exists:tour_size,id',              
        'vehicle'=>'required|exists:product_vehicle,id', 
        'minimumnumberofdepartures'=>'nullable|integer|min:0',]);
        //unique:product,title|
      $user=Auth::user();
      $product=Product::where('id',$req->product)->where('userid',$user->id)->first();
      if($product==NULL){
        return redirect(404);
      }
      $now=now();
      foreach ($req->language as $language) {
        ProductLanguage::updateOrCreate([
            'languageid'=>$language,
            'productid'=>$product->id],
            ['updated_at'=>$now,]);
      }
      $country=Country::where('name',$req->country)->first();
      $category=Category::where('name',$req->category)->first();
      $city=NULL;
      if($req->city!=NULL){
        $c=City::where('name',$req->city)->first();
        $city=$c->id;
      }
      $product->countryid=$country->id;
      $product->categoryid=$category->id;
      $product->nocity=$req->nocity; 
      $product->cityid=$city;

      //this 3 rows need confirmation ....      
      $changetitle=NULL;
      $changeonelinesummary=NULL;
      $changetravelintroduction=NULL;
      if($product->title!=$req->title){
        $changetitle=$req->title;
      }
      if($product->onelinesummary!=$req->onelinesummary){
        $changeonelinesummary=$req->onelinesummary;
      }
      if($product->introduction!=$req->travelintroduction){
        $changetravelintroduction=$req->travelintroduction;
      }
      if($changetitle !=NULL || $changetravelintroduction !=NULL || $changeonelinesummary!=NULL){
      ProductChangeConfirmation::updateOrCreate(['productid'=>$product->id,'confirmbyuserid'=>NULL],
          ['title'=>$changetitle,
            'onelinesummary'=>$changeonelinesummary,
            'introduction'=>$changetravelintroduction]);
      }

           /* 
      $product->onelinesummary=$req->onelinesummary;
      $product->title=$req->title;
      $product->introduction=$req->travelintroduction;
*/

      $product->toursizeid=$req->toursize;
      $product->photorights=1;
      $product->vehicleid=$req->vehicle;
       $product->page1=true;
      $product->minimumnumberofdepartures=$req->minimumnumberofdepartures;
      $product->save();
      ProductLanguage::where('productid',$product->id)->where('updated_at','<',$now)->delete();
      //
      foreach ($req->subcategory as $subcategory) {
        ProductSubcategory::updateOrCreate([
          'productid'=>$product->id,
          'subcategoryid'=>$subcategory,
          ],[
            'updated_at'=>$now,
          ]);        
      }
      ProductSubcategory::where('productid',$product->id)->where('updated_at','<',$now)->delete();

      /* photo upload */
        //$path=$data['continent']."/".$data['region']."/".$country->name;

        foreach($product->photo as $productphoto){
            $row=$productphoto->photo;
            $c= $req->d7;
            if($req["d".$row->id]==true){          
                $path=public_path('image/tour').'/'.$row->name;
                $row->delete();                
               // if(File::exists($path)){
                  unlink($path);
                //}
            }
        }
        

       if ($req->hasFile('photos')) {
       //   echo "true1";
         $files=$req->file('photos');
            $i=1;
            foreach($files as $file){                
                $filenameWithExt = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $now=now();               
                $fileNameToStore = $filename.$now.'a_'.time().$i.'.'.$extension;
                $file->move(public_path('image/tour'), $fileNameToStore);
                $i++;

                //ImageOptimizer::optimize(public_path('image/tour').'/'.$fileNameToStore );

                ImageOptimizer::optimize(public_path('image/tour').'/'.$fileNameToStore, public_path('image/tour').'/'.$fileNameToStore );
                Image::make(public_path('image/tour').'/'.$fileNameToStore)->encode('jpg',65)
                  ->resize(1024, NULL, function ($constraint) {
                      $constraint->aspectRatio();
                  })
                  ->save(public_path('image/tour').'/'.$fileNameToStore);

             //   print_r($r);
                $newphoto=Photo::create([
                  'name'=>$fileNameToStore,
                  'folder'=>'/image/tour',
                  'extension'=>$extension,
                  //'cityid'=>$city->id,
                  //'notes'=>'cover',
                  ]);
                ProductPhoto::create([
                  'productid'=>$product->id,
                  'photoid'=>$newphoto->id]);
              }
        }

      /*
      
        $path="tour";
        $extension="";
        $fileNameToStore="";
        if ($req->hasFile('image')) {
              $filenameWithExt = $req->file('image')->getClientOriginalName();
              $extension = $req->file('image')->getClientOriginalExtension();
              $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
              $now=now();            
              $fileNameToStore=$filename.$now.'.'.$extension;
              $req->image->move(public_path('image/'.$path), $fileNameToStore);
              Photo::create([
              'name'=>$fileNameToStore,
              'folder'=>'/image/'.$path,
              'extension'=>$extension,
              //'cityid'=>$city->id,
              //'notes'=>'cover',
              ]);
        }
      */
      /* photo upload end */
      return redirect(route('partner.product.editpage2',['locale'=>app()->getLocale(),'product'=>$product->id ]))->with('success', 'Save complete'); 
    }
    public function posteditpage2(Request $req){
      $validateDate=$req->validate([
        'product'=>'required|exists:product,id',
        'meetingtime'=>'required',
        'nameofmeetingplace'=>'required|string|max:250',
        'meetingplacelocation'=>'nullable|string|max:250',

        'meetingplacephoto'=>'',

        //tour course....
        'tcourseid.*'=>'',
        'tcoursetitle.*'=>'required|string|max:250',
        'tcoursehour.*'=>'required|integer|min:0',
        'tcourseminute.*'=>'required|integer|min:0|max:60',
        'tcoursecontent.*'=>'string|max:3000',

        'totalreqday'=>'integer|min:0',
        'totalreqhour'=>'integer|min:0|max:24',
        'totalreqmin'=>'integer|min:0',


        'FromDate'=>'nullable|date',
        'ToDate'=>'nullable|date',
        'days.*'=>'',
        'hours.*'=>'nullable',
      ]);
      $user=Auth::user();
      $product=Product::where('id',$req->product)->where('userid',$user->id)->first();
      if($product==NULL){
        return redirect(404);
      }
      $now=now();
      $product->meetingtime=$req->meetingtime;

      $changemeetingplacename=NULL;
      $changemeetingplacecoordinate=NULL;
      if($product->meetingplacename!=$req->nameofmeetingplace){
        $changemeetingplacename=$req->nameofmeetingplace;
      }
      if($product->meetingplacecoordinate!=$req->meetingplacelocation){
        $changemeetingplacecoordinate=$req->meetingplacelocation;
      }
      if($changemeetingplacename!=NULL || $changemeetingplacecoordinate!=NULL){
        ProductChangeConfirmation::updateOrCreate(['productid'=>$product->id,'confirmbyuserid'=>NULL],
          ['meetingplacename'=>$changemeetingplacename,
          'meetingplacecoordinate'=>$changemeetingplacecoordinate]);
      }



      if($req->FromDate!=NULL){
        $hours=[];
        if(is_array( $req->hours)){
          foreach ($req->hours as $key => $value) {
            if($value!=NULL){
              array_push($hours, $value);
            }
          }
        }
        $pavailableui=ProductAvailableUi::updateOrCreate([
            'productid'=>$product->id,
          ],[
            'from_date'=>$req->FromDate,
            'to_date'=>$req->ToDate,
            'monday'=>$req->days[1]??false,
            'tuesday'=>$req->days[2]??false,
            'wednesday'=>$req->days[3]??false,
            'thursday'=>$req->days[4]??false,
            'friday'=>$req->days[5]??false,
            'saturday'=>$req->days[6]??false,
            'sunday'=>$req->days[7]??false,
            'hour'=>json_encode($hours),
          ]);
        $from=Carbon::createFromDate($req->FromDate);
        $todate=Carbon::createFromDate($req->ToDate);
        while($from<$todate){
          if(is_array( $req->hours)){
            foreach ($hours as $hrow) {

              if($pavailableui[strtolower($from->isoFormat('dddd')) ]){
                ProductAvailable::updateOrCreate([
                  'productid'=>$product->id,
                  'available_uiid'=>$pavailableui->id,
                  'date'=>$from->format('Y-m-d'),
                  'hour'=>$hrow,
                  ],[
                    'updated_at'=>$now,
                  ]);
              }
            }
          }
          $from->addDay();
        }

        ProductAvailable::where('productid',$product->id)->where('available_uiid',$pavailableui->id)
        ->where('updated_at','<',$now)->delete();
      }
      
      /*
      $product->meetingplacename=$req->nameofmeetingplace;
      $product->meetingplacecoordinate=$req->meetingplacelocation;
      meetingplacecoordinate
      */

      $product->totalrequiredday=$req->totalreqday;
      $product->totalrequiredhour=$req->totalreqhour;
      $product->totalrequiredminute=$req->totalreqmin;
       $product->page2=true;
      $product->save();

      //$path=$data['continent']."/".$data['region']."/".$country->name;
      foreach($product->meetingphoto as $productphoto){
            $row=$productphoto->photo;
            $c= $req->d7;
            if($req["d".$row->id]==true){          
                $deletepath=public_path($row->folder).'/'.$row->name;
                unlink($deletepath);
                $row->delete();
            }
      }
      $path="tour/meetingplace";
      $extension="";
      $fileNameToStore="";
      if ($req->hasFile('meetingplacephoto')) {
          foreach($product->meetingphoto as $productphoto){
            $row=$productphoto->photo;
            $deletepath=public_path($row->folder).'/'.$row->name;
            unlink($deletepath);
            $row->delete();
          }
            $filenameWithExt = $req->file('meetingplacephoto')->getClientOriginalName();
            $extension = $req->file('meetingplacephoto')->getClientOriginalExtension();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $now=now();            
            $fileNameToStore = $filename.$now.'a_'.time().'.'.$extension;
            $req->meetingplacephoto->move(public_path('image/'.$path), $fileNameToStore);
            $newphoto=Photo::create([
                  'name'=>$fileNameToStore,
                  'folder'=>'/image/'.$path,
                  'extension'=>$extension,
                  ]);
            Image::make(public_path($newphoto->folder).'/'.$fileNameToStore)->encode('jpg',65)
                  ->resize(1024, NULL, function ($constraint) {
                      $constraint->aspectRatio();
                  })
                  ->save(public_path($newphoto->folder).'/'.$fileNameToStore);

            ProductMeetingPhoto::create([
                  'productid'=>$product->id,
                  'photoid'=>$newphoto->id]);
      }
//      print_r($req->tcoursetitle);
      if(isset($req->tcoursetitle)){
        for($i=0;$i<count($req->tcoursetitle);$i++){
          if(isset($req->tcourseid[$i])){          
            $tourcourse=TourCourse::where('id',$req->tcourseid[$i])->first();
            //$tourcourse->title=$req->tcoursetitle[$i];
            //$tourcourse->content=$req->tcoursecontent[$i];
            $tourcourse->hour=$req->tcoursehour[$i];
            $tourcourse->minute=$req->tcourseminute[$i];
            $tourcourse->save();

            $changetitle=NULL;
            $changeconent=NULL;
            if($req->tcoursetitle[$i]!=$tourcourse->title){
              $changetitle=$req->tcoursetitle[$i];
            }
            if($req->tcoursecontent[$i]!=$tourcourse->content){
              $changeconent=$req->tcoursecontent[$i];
            }
            if($changetitle!=NULL || $changeconent!=NULL){
              TourCourseChangeLogConfirm::updateOrCreate([
                'tour_courseid'=>$tourcourse->id,
                'confirmbyuserid'=>NULL
                ],[
                  'title'=>$changetitle,
                  'content'=>$changeconent,
                ]);
            }
            foreach($tourcourse->photo as $productphoto){
              $row=$productphoto->photo;
              $c= $req->d7;
              if($req["d".$row->id]==true){          
                  $row->delete();
              }
            }
            if(isset($req->tourcoursephoto[$i])){     
                  $path="tour/tourcourse";
                  $extension="";
                  $fileNameToStore="";       
                  if ($req->hasFile('tourcoursephoto.'.$i)) {
                    
                      foreach($tourcourse->photo as $productphoto){
                        $row=$productphoto->photo;
                        $row->delete();
                      }
                      $filenameWithExt = $req->file('tourcoursephoto.'.$i)->getClientOriginalName();
                      $extension = $req->file('tourcoursephoto.'.$i)->getClientOriginalExtension();
                      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                      $now=now();            
                      $fileNameToStore = $filename.$now.'a_'.time().'.'.$extension;
                      $req->tourcoursephoto[$i]->move(public_path('image/'.$path), $fileNameToStore);
                      $newphoto=Photo::create([
                            'name'=>$fileNameToStore,
                            'folder'=>'/image/'.$path,
                            'extension'=>$extension,
                            ]);
                      Image::make(public_path($newphoto->folder).'/'.$fileNameToStore)->encode('jpg',65)
                        ->resize(1024, NULL, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save(public_path($newphoto->folder).'/'.$fileNameToStore);
                        
                      TourCoursePhoto::create([
                            'tour_courseid'=>$tourcourse->id,
                            'photoid'=>$newphoto->id]);
                  }
             /*    
                if ($req->hasFile('photos')) {
                    echo "true1";
                   $files=$req->file('photos');
              */
            }
          }else{
  /*
            print_r($req->tcoursetitle);
            echo "<br>hour ";
            print_r($req->tcoursehour);
            echo "<br>minute ";
            print_r($req->tcourseminute);
            echo "<br>";
            print_r($req->tcoursecontent);
            */
            
            TourCourse::create([
              'title'=>$req->tcoursetitle[$i],
              'content'=>$req->tcoursecontent[$i],
              'hour'=>$req->tcoursehour[$i],
              'minute'=>$req->tcourseminute[$i],
              'productid'=>$product->id
              ]);
          }        
        }
      }


      //meetingplacephoto
      return redirect(route('partner.product.editpage3',['locale'=>app()->getLocale(),'product'=>$product->id ]))->with('success', 'Save complete'); 
      return redirect()->back()->with('success', 'Save complete');   
    }
    public function posteditpage3(Request $req){
      $validateDate=$req->validate([
        'product'=>'required|exists:product,id',

        'pricetype'=>'required|exists:price_type,name',
        //requiredIf
        'minimum'=>'required_if:pricetype,simple|nullable|integer|min:0',
        'maximum'=>'required_if:pricetype,simple|nullable|integer|min:0',
        'currency'=>'required|exists:currency,id',
        //'currency'=>'required_if:pricetype,simple|nullable|exists:currency,id',
        'amount'=>'required_if:pricetype,simple|nullable|integer|min:1',

        //'currencyper'=>'required_if:pricetype,priceperperson|nullable|exists:currency,id',
        'person.*'=>'required_if:pricetype,priceperperson|nullable|integer|min:0',
          //['required_if:pricetype,priceperperson','nullable','integer','min:0',
        //Rule:: unique('product_price','person')->where('productid',) 
        
        'price.*'=>'required_if:pricetype,priceperperson|nullable|integer|min:1',

        'priceincluded'=>'required|string|max:2000',
        'pricenotincluded'=>'nullable|string|max:2000',
        'essentialguidance'=>'nullable|string|max:2000',
        'additional'=>'',

      //  'ticketcurrency'=>'required|exists:currency,id',
        'tickettitle.*'=>'required|string',
        'ticketprice.*'=>'required|integer|min:0',

        //'ticketcurrency.*'=>'required|exists:currency,id',
        'ticketvalid.*'=>'nullable|date|after:tomorrow',
        'ticketshortdesc.*'=>'nullable|string',

        'available.*.ticket'=>'',
        'available.*.date'=>'',
        'available.*.hour'=>'',
        'available.*.piece'=>'',
        ]);
      //currencyper
      //ticketcurrency

        $checkperson=[];
        $i=0;
        if(isset($req->person)){
          foreach ($req->person as $row) {
            if(isset($checkperson[$row]) && $checkperson[$row]>=1){            
               $error=\Illuminate\Validation\ValidationException::withMessages([
                'person.'.$i=>['error']
               ]);
               throw $error;
            }
            $i++;
            $checkperson[$row]=1;
          }
        }
        $user=Auth::user();
        $now=now();
        $product=Product::where('id',$req->product)->where('userid',$user->id)->first();
        if($product==NULL){
          return redirect(404);
        }
        $pricetype=PriceType::where('name',$req->pricetype)->first();
        $product->pricetypeid=$pricetype->id;       

        $changenotincluded=NULL;
        $changepriceincluded=NULL;
        $changeessentialguidance=NULL;
        if($product->priceincluded!=$req->priceincluded){
          $changepriceincluded=$req->priceincluded;
        }
        if($product->notincluded!=$req->pricenotincluded){
          $changenotincluded=$req->pricenotincluded;
        }
        if($product->essentialguidance!=$req->essentialguidance){
          $changeessentialguidance=$req->essentialguidance;
        }
        if($changepriceincluded!=NULL || $changenotincluded!=NULL || $changeessentialguidance!=NULL){
          ProductChangeConfirmation::updateOrCreate(['productid'=>$product->id,'confirmbyuserid'=>NULL],
            ['priceincluded'=>$changepriceincluded,
            'notincluded'=>$changenotincluded,
            'essentialguidance'=>$changeessentialguidance]);         
        }
        /*
        $product->priceincluded=$req->priceincluded;
        $product->notincluded=$req->pricenotincluded;
        $product->essentialguidance=$req->essentialguidance;*/

        if($pricetype->name=="simple"){
          //remove old
          //ProductPrice::where('productid',$product->id)
          ProductPrice::where('productid',$product->id)->where('notes','!=','simple')->delete();
          ProductPrice::updateOrCreate(['productid'=>$product->id,'notes'=>'simple'],
                ['minimumpeople'=>$req->minimum,
                'maximumpeople'=>$req->maximum,
                //'person'=>
                'amount'=>$req->amount,
                'currencyid'=>$req->currency,
                'updated_at'=>$now,
                ]);
          ProductPrice::where('productid',$product->id)->where('updated_at','<',$now)->delete();
        }else{
          ProductPrice::where('productid',$product->id)->where('notes','simple')->delete();
          //print_r($req->person);
          //return 0;
          if(is_array($req->person)){
            for($i=0;$i<count($req->person);$i++){

              if(isset($req->priceperid[$i])){     
             //   DB::enableQueryLog(); 
                ProductPrice::where('id',$req->priceperid[$i])->update([
                  'currencyid'=>$req->currency,
                  'person'=>$req->person[$i],
                  'amount'=>$req->price[$i],
                  'updated_at'=>$now,
                  ]);
              //  dd(DB::getQueryLog()); 

              }else{
              ////amount????  
                
                ProductPrice::create([
                  'productid'=>$product->id,
                  'currencyid'=>$req->currency,
                  //'minimumpeople'=>$req->minimum[$i],
                  //'maximumpeople'=>$req->maximum[$i],
                  'person'=>$req->person[$i],
                  'amount'=>$req->price[$i],
                  ]);
                
              }
            }         
          }
          ProductPrice::where('productid',$product->id)->where('updated_at','<',$now)->delete();
          $uppers=ProductPrice::where('productid',$product->id)->orderBy('person')->first();
          $uppers->minimumpeople=$uppers->person;
          $uppers->save();
          $uprice=ProductPrice::where('productid',$product->id)->orderBy('person','DESC')->first();
          $uprice->maximumpeople=$uprice->person;
          $uprice->save();
        }
       // ProductPrice::where('productid',$product->id)->where('updated_at','<',$now)->delete();
        
        if(isset($req->tickettitle)){
          for ($i=0; $i < count($req->tickettitle); $i++) {             
            if(isset($req->ticketid[$i])){
              $pticket=ProductTicket::where('id',$req->ticketid[$i])->update([
               // 'title'=>$req->tickettitle[$i],
                //'shortdesc'=>$req->ticketshortdesc[$i],
                'currencyid'=>$req->currency,
                'price'=>$req->ticketprice[$i],
                'expire'=>$req->ticketvalid[$i],
                'eticket'=>$req->eticket,                
                'updated_at'=>$now,
              ]);
              $pticket=ProductTicket::where('id',$req->ticketid[$i])->first();
              $pticketchangetitle=NULL;
              $pticketchangeshortdesc=NULL;
              if($pticket->title!=$req->tickettitle[$i]){
                $pticketchangetitle=$req->tickettitle[$i];
              }
              if($pticket->shortdesc!=$req->ticketshortdesc[$i]){
                $pticketchangeshortdesc=$req->ticketshortdesc[$i];
              }
              if($pticketchangetitle!=NULL || $pticketchangeshortdesc!=NULL){
                ProductTicketChange::updateOrCreate([
                  'product_ticketid'=>$pticket->id,
                  'confirmbyuserid'=>NULL
                  ],[
                    'title'=>$pticketchangetitle,
                    'shortdesc'=>$pticketchangeshortdesc,
                    'updated_at'=>$now,
                  ]);
              }
            }else{
              ProductTicket::create([
                'productid'=>$product->id,
                'title'=>$req->tickettitle[$i],
                'shortdesc'=>$req->ticketshortdesc[$i],
                'currencyid'=>$req->currency,
                'price'=>$req->ticketprice[$i],
                'expire'=>$req->ticketvalid[$i],
                'eticket'=>$req->eticket,                
              ]);
            }
          }
        }
        ProductTicket::where('productid',$product->id)->where('updated_at','<',$now)->delete();
        $product->additionalairarrival=false;
        $product->additionalflightdeparture=false;
        $product->additionalhotel=false;
        if($req->additional!=NULL){
          foreach ($req->additional as $value) {
            switch ($value) {
              case 'hotel':
                $product->additionalhotel=true;
                break;
              case 'flightdeparture':
                $product->additionalflightdeparture=true;
                break;
              case 'airarrival':
                $product->additionalairarrival=true;
                break;
              
              default:                
                break;
            }
          }
        }
        $product->page3=true;
        $product->save();

        foreach ($req->available as $key => $a_row) {
          $a_ticket=ProductTicket::where('id',$a_row['ticket'])->first();
          if($a_ticket->productid!=$product->id){
            abort(403);
          }
          /**
       'available.*.ticket'=>'',
        'available.*.date'=>'',
        'available.*.hour'=>'',
        'available.*.piece'=>'',
           * **/
            $temp_data=ProductTicketAvailablePiece::whereHas('ticketAvailable',function($query)use($a_ticket){
                $query->where('product_ticket_id',$a_ticket->id);
            })->whereHas('availableDate',function($date_query)use($a_row){
                $date_query->where('date',$a_row['date'])
                    ->where('hour',$a_row['hour']);
            })
            ->first();
            if($temp_data==NULL){
              //not have data
              $p_available=ProductAvailable::where('date',$a_row['date'])
                ->where('hour',$a_row['hour'])
                ->where('productid',$product->id)
                ->first();

              $p_available_piece=ProductTicketAvailablePiece::create([
                  'availableid'=>$p_available->id,
                  'piece'=>$a_row['piece'],
                  ]);
              ProductTicketAvailable::create([
                'product_ticket_available_piece_id'=>$p_available_piece->id,
                'product_ticket_id'=>$a_ticket->id,
                ]);
            }else{
              $temp_data->piece=$a_row['piece'];
              $temp_data->save();
            }
        }
              return redirect()->back()->with('success', 'Save complete'); 
    }




    public function ajaxcity(Request $req){
          $id=$req->id;
          $old=$req->old;
          $msg="<option value=''>".__('messages.select')."</option>";
          $region=Country::where('name',$id)->first();
          if($region!=NULL){
            foreach ($region->cities as $city) {
              $txt="";
              if($old==$city->name){
                $txt="selected";
              }
              $cityname=json_decode($city->namearray,true);
              $cname="";
              $loc=app()->getLocale();
              if(isset($cityname[$loc])){
                $cname=$cityname[$loc];
                
              }else{
                $cname=$city->name;
              }


              $msg.="<option value='".$city->name."' ".$txt.">".$cname."</option>";
            }
          }
          return response()->json(array('msg'=> $msg), 200);
    }


    public function postansware(Request $req){
      $validateDate=$req->validate([
        'product'=>'required|exists:product,id',
        'replyby'=>'required|exists:message,id',
        'text'=>'required|string|max:2900',
        'type'=>'required|exists:message_type,id',
        ]);
      $user=Auth::user();
      $m=Message::create([
        'text'=>$req->text,
        'replybyid'=>$req->replyby,
        'typeid'=>$req->type,
        'fromuserid'=>$user->id,
        'productid'=>$req->product,
        ]);
      return redirect()->back()->with('success','Save complete');
    }

    public function deleteproduct(Request $req){
      $validateDate=$req->validate([
        'delete'=>'required|exists:product,id']);
      $user=Auth::user();
      Product::where('id',$req->delete)->where('userid',$user->id)->update(['remove'=>1]);
      return redirect()->back()->with('success','Delete complete');
   }
   public function reservationresponse(Request $req){
  //  $validateDate=$req->validate(['reservation'=>'required|exists:reservation,id']);

    $data['reservation']=Reservation::where('id',$req->reservation)->first();
    if($data['reservation']==NULL){
      return redirect(404);
    }
    $data['locale']=app()->getLocale();
    return view('partner.reservationconfirm')->with('data',$data);

   }
   public function postreservationresponse(Request $req){
    $validateDate=$req->validate([
      'reservation'=>'required|exists:reservation,id',
      'respones'=>'required',
      ]);
      $reservation=Reservation::where('id',$req->reservation)->first();
      $reservation->accept=$req->response;  
   }
}

