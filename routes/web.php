<?php

use Illuminate\Support\Facades\Route;

use App\Product;
use App\Reservation;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* 
Route::get('/', function () {
    return view('index');
});*/
Route::get('/', function ( Request $req) {
	$loc=env('DEFAULT_LOCAL','en');    
	$lang=$loc;
	try {
	  $loc= substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
	} catch (Exception $e) {
	  $loc="en";
	}
	$loc="ko";
  	$list=env('AVAILABLE_LOCAL', 'en');
    $exp=explode(',',$list);
    foreach ($exp as $row) {
		if($loc==$row){
		    $true=1;
		    $lang=$loc;
		}            
    }
    app()->setLocale($lang);
  //  return app('App\Http\Controllers\indexController')->home($req);
    return app('App\Http\Controllers\IndexController')->index();
    //return view('index');
})->name('main');



/*
Route::get('emailview',function(){
	$data['product']=Product::first();
	$data['reservation']=Reservation::first();
	$data['tomorrow']=date('Y-m-d',strtotime('1 days'));

	$data['locale']=app()->getLocale();

	return view('emails.partner_reservation')->with('data',$data);
	return view('emails.reservation')->with('data',$data);
});*/
//Auth::routes(['verify' => true]);

Route::group([
  'prefix' => '{locale}', 
  'where' => ['locale' => '[a-zA-Z]{2}'], 
  'middleware' => 'setlocale'], function() {


  	Route::get('/','IndexController@index')->name('index');
  	Route::get('/cities/{slug}','IndexController@cities')->name('cities');
  	Route::get('/regions','RegionController@index')->name('region');
  	Route::get('/offers','IndexController@offers')->name('offers');
		Route::get('/offers/{slug}','IndexController@offersproduct')->name('offers.product');
		Route::get('/offersproduct','IndexController@offersproductbyid')->name('offers.product.byid');

  	Route::get('/ajax/cities','IndexController@ajaxlistcities')->name('ajaxlistcities');

  	Route::get('/partnersignup','IndexController@partnersignup')->name('partnersignup');
  	Route::post('/partnersignup','IndexController@postpartnersignup')->name('partnersignup');
  	/***
  	 * Bus search
  	 * **/
  	Route::group(['prefix'=>'bus'],function(){
  		Route::get('/','Bus\BusController@search')->name('bus.search');
  		Route::get('/{region}/{country}/{subpage}','Bus\BusSubpageController@subpage')->name('bus.subpage');
  	});
  	/***
  	 * Hotel search
  	 * **/
  	Route::group(['prefix'=>'hotel'],function(){
  		Route::get('/','Hotel\HotelController@search')->name('hotel.search');
  		Route::get('/{region}/{country}/{subpage}','Hotel\HotelSubpageController@subpage')->name('hotel.subpage');
  	});
  	/***
  	 * Restaurant search
  	 * **/
  	Route::group(['prefix'=>'restaurant'],function(){
  		Route::get('/','Restaurant\RestaurantController@search')->name('restaurant.search');
  		Route::get('/{region}/{country}/{subpage}','Restaurant\RestaurantSubpageController@subpage')->name('restaurant.subpage');
  	});


//'middleware'=>'verified'

	Route::group(['middleware'=>'auth' ], function () {
		/***
		 * Bus contact
		 * **/
		Route::group(['prefix'=>'bus'],function(){
			Route::get('contact','Bus\BusController@Contact')->name('bus.customer.message');
			Route::post('contact','Bus\BusController@PostContact')->name('bus.customer.message.post');

			Route::get('busfind/contact','Bus\BusController@ContactBusFind')->name('bus.find.message');
			Route::post('busfind/contact','Bus\BusController@PostContactBusFind')->name('bus.find.message.post');
		});
		/**
		 * hotel contact
		 * **/
		Route::group(['prefix'=>'hotel'],function(){
			Route::get('contact','Hotel\HotelController@Contact')->name('hotel.customer.message');
			Route::post('contact','Hotel\HotelController@PostContact')->name('hotel.customer.message.post');
		});
		/**
		 * restaurant contacct
		 * **/
		Route::group(['prefix'=>'restaurnat'],function(){
			Route::get('contact','Restaurant\RestaurantController@Contact')->name('restaurant.customer.message');
			Route::post('contact','Restaurant\RestaurantController@PostContact')->name('restaurant.customer.message.post');
		});


		Route::get('/verifycomplete','User\UserController@verifycomplete')->name('user.verifycomplete');
		Route::get('/order','User\UserController@orders')->name('user.orders');

		Route::get('/account','User\UserController@account')->name('account');
		Route::get('/account/edit','User\UserController@edit')->name('account.edit');
		Route::post('/account/edit','User\UserController@postedit')->name('account.edit');
		Route::get('/account/changepassword','User\UserController@changepassword')->name('account.changepassword');
		Route::post('/account/changepassword','User\UserController@postchangepassword')->name('account.changepassword');

		//Route::get('/reservation','User\UserController@reservation')->name('reservation');
		Route::post('/reservation','User\UserController@postreservation')->name('reservation');
		Route::get('/paymethods','User\UserController@selectpaymethod')->name('paymethods');
		Route::get('/pay','Paymethods\PaymethodsController@index')->name('pay');

		/*partner*/
		Route::group(['middleware'=>'authpartner','prefix'=>'partner'],function(){			
			/***
			 * Tour/Ticket
			 * **/
			Route::get('/','Partner\PartnerController@index')->name('partner');
			Route::group(['middleware'=>'authtourticket', 'prefix'=>'tour'],function(){
						Route::get('/product','Partner\PartnerController@product')->name('partner.product');
						Route::get('/product/add','Partner\PartnerController@addproduct')->name('partner.product.add');
						Route::post('/product/add','Partner\PartnerController@addproductpost')->name('partner.product.add');
						Route::get('/product/edit/1','Partner\PartnerController@editpage1')->name('partner.product.editpage1');
						Route::middleware('optimizeImages')->group(function () {
							Route::post('/product/edit/1','Partner\PartnerController@posteditpage1')->name('partner.product.editpage1');
						});
						Route::post('/product/delete','Partner\PartnerController@deleteproduct')->name('partner.product.delete');
						Route::get('/product/edit/2','Partner\PartnerController@editpage2')->name('partner.product.editpage2');
						Route::post('/product/edit/2','Partner\PartnerController@posteditpage2')->name('partner.product.posteditpage2');		
						Route::get('/product/edit/3','Partner\PartnerController@editpage3')->name('partner.product.editpage3');
						Route::post('/product/edit/3','Partner\PartnerController@posteditpage3')->name('partner.product.editpage3');
						Route::post('/product/answare','Partner\PartnerController@postansware')->name('partner.product.answare');
						Route::get('/reservation/response','Partner\PartnerController@reservationresponse')->name('partner.reservation.response');
						Route::post('/reservation/response','Partner\PartnerController@postreservationresponse')->name('partner.reservation.postresponse');
						//Route::get('/edit','Partner\PartnerController@edit')->name('partner.edit');
						Route::get('/city','Partner\PartnerController@ajaxcity')->name('partner.ajaxcity');
						Route::get('/dashboard','Partner\DashboardController@dashboard')->name('partner.dashboard');
			});
			/**
			 * Bus partner
			 * **/
			Route::group(['middleware'=>'authbus','prefix'=>'bus'],function(){
				Route::get('/','Bus\Partner\PartnerBusController@index')->name('partner.bus.index');
				Route::get('/buses','Bus\Partner\PartnerBusController@buses')->name('partner.bus.buses');
				Route::post('/buses/add','Bus\Partner\PartnerBusController@addBus')->name('partner.bus.buses.add');
				Route::post('/buses/delet','Bus\Partner\PartnerBusController@deleteBus')->name('partner.bus.buses.delete');
				Route::any('/buses/edit','Bus\Partner\PartnerBusController@postEditBus')->name('partner.bus.buses.postedit');
				Route::post('/ajax/busmodels','Bus\Partner\PartnerBusController@ajaxModel')->name('ajax.bus.model');
				Route::any('/ajax/editbus','Bus\Partner\PartnerBusController@editBus')->name('partner.bus.buses.edit');

				Route::any('/ajax/available','Bus\Partner\PartnerBusController@ajaxAvailableBus')->name('partner.ajax.bus.available.calendar');
				Route::post('/buses/available/new','Bus\Partner\PartnerBusController@newAvailableC')->name('partner.bus.available.new');
				Route::post('/buses/available/loadedit','Bus\Partner\PartnerBusController@loadEditAvailable')->name('partner.bus.available.loadedit');
				Route::post('/buses/available/edit','Bus\Partner\PartnerBusController@editAvailable')->name('partner.bus.available.edit');

				Route::get('/subpage','Bus\Partner\PartnerBusSubpageController@index')->name('partner.bus.subpage');
				Route::post('/subpage/save','Bus\Partner\PartnerBusSubpageController@postEdit')->name('partner.bus.subpage.save');
			});
			/****
			 * Hotel partner
			 * **/
			Route::group(['middleware'=>'authhotel','prefix'=>'hotel'],function(){
				Route::get('/','Hotel\Partner\PartnerHotelController@index')->name('partner.hotel.index');
				Route::post('/room/delete','Hotel\Partner\PartnerHotelController@deleteRoom')->name('partner.hotel.room.delete');
				Route::post('/room/add','Hotel\Partner\PartnerHotelController@addRoom')->name('partner.hotel.room.add');
				Route::post('/room/getEdit','Hotel\Partner\PartnerHotelController@editRoom')->name('partner.hotel.room.edit');
				Route::post('/room/edit','Hotel\Partner\PartnerHotelController@postEditRoom')->name('partner.hotel.room.postedit');
				Route::any('/room/getAvailable','Hotel\Partner\PartnerHotelController@getAvailable')->name('partner.hotel.room.getcalendar');
				Route::post('/room/available','Hotel\Partner\PartnerHotelController@available')->name('partner.hotel.room.postcalendar');

				Route::get('/subpage','Hotel\Partner\PartnerHotelSubpageController@index')->name('partner.hotel.subpage');
				Route::post('/subpage/save','Hotel\Partner\PartnerHotelSubpageController@postEdit')->name('partner.hotel.subpage.save');
			});
			/****
			 * Restaurnat partner
			 * **/
			Route::group(['middleware'=>'authrestaurant','prefix'=>'restaurant'],function(){
				Route::get('/','Restaurant\Partner\PartnerRestaurantController@index')->name('partner.restaurant.index');

				Route::post('/menu/add','Restaurant\Partner\PartnerRestaurantController@AddMenu')->name('partner.restaurant.menu.add');
				Route::any('/menu/getEdit','Restaurant\Partner\PartnerRestaurantController@GetEditMenu')->name('partner.restaurant.menu.getEdit');
				Route::post('/menu/edit','Restaurant\Partner\PartnerRestaurantController@EditMenu')->name('partner.restaurant.menu.postedit');
				Route::post('/menu/delete','Restaurant\Partner\PartnerRestaurantController@DeleteMenu')->name('partner.restaurant.menu.delete');


				Route::get('/subpage','Restaurant\Partner\PartnerRestaurantSubpageController@index')->name('partner.restaurant.subpage');
				Route::post('/subpage/save','Restaurant\Partner\PartnerRestaurantSubpageController@postEdit')->name('partner.restaurant.subpage.save');
			});
		});
		
		/**
		 * admin middleware
		 * **/
		Route::group(['middleware'=>'authadmin','prefix'=>'admin'],function(){
			Route::get('/','Admin\AdminController@index')->name('admin');
			Route::get('/cities','Admin\CitiesController@index')->name('admin.cities');
			Route::post('/cities/add','Admin\CitiesController@add')->name('admin.cities.add');
			Route::get('/cities/edit','Admin\CitiesController@edit')->name('admin.cities.edit');
			Route::post('/cities/edit','Admin\CitiesController@postedit')->name('admin.cities.edit');
			Route::post('/cities/delete','Admin\CitiesController@delete')->name('admin.cities.delete');
			//Route::post('/region','Admin\AdminController@ajaxregion')->name('ajaxregion');
			Route::get('/region','Admin\AjaxController@ajaxregion')->name('ajaxregion');
			Route::get('/country','Admin\AjaxController@ajaxcountry')->name('ajaxcountry');
			

			Route::get('/users','Admin\UsersController@users')->name('admin.users');
			Route::post('/users','Admin\UsersController@addnewuser')->name('admin.addnewuser');
			Route::get('/user/edit','Admin\UsersController@edituser')->name('admin.users.edit');
			Route::post('/user/edit','Admin\UsersController@postedituser')->name('admin.users.edit');


			Route::get('/ajax/product','Admin\ProductController@ajaxproduct')->name('ajaxproduct');
			Route::get('/product','Admin\ProductController@index')->name('admin.product');
			Route::post('/product/confirm','Admin\ProductController@postconfirm')->name('admin.product.confirm');
			Route::get('/dashboard','Admin\DashboardController@index')->name('admin.dashboard');			 	
			//advertising start
			Route::get('/advertising','Admin\AdminController@advertising')->name('admin.advertising');
			Route::get('/advertising/edit','Admin\AdminController@advertisingedit')->name('admin.advertising.edit');
			Route::post('advertising/edit','Admin\AdminController@advertisingpostedit')->name('admin.advertising.edit');
			Route::post('advertising/add','Admin\AdminController@advertisingadd')->name('admin.advertising.add');						
			Route::post('/advertising/delete','Admin\AdminController@advertisingdelete')->name('admin.advertising.delete');	
			//		
		});
		/*
		Route::group(['prefix'=>''],function(){

		});*/

	});
	
	Auth::routes();
//	Auth::routes(['verify' => true]);

	//Route::get('/home', 'HomeController@index')->name('home');

});

//
	//Auth::routes();
Route::any('refresh-csrf', function(){     
  return csrf_token(); 
}); 


//Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
//Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');


//Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');


/*
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/users/emailverified');
})->middleware(['auth', 'signed'])->name('verification.verify');
*/



//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
