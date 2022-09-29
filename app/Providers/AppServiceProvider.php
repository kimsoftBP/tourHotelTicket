<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;
use App\Product;
use App\User;
use App\City;
use App\LogViewProduct;
use App\BusCompany;
use App\Bus;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        if(Schema::hasTable('product')){
            $data['tours']=Product::where('checkadmin',1)->where('remove',0)->count();
            $data['guides']=User::whereHas('permission',function($query){
                        $query->whereHas('permissionName',function($permquery){
                            $permquery->where('perm_name','partner');
                        });
                    })->count();
            $data['destinations']=City::whereHas('products')->count();        
            $data['bus']=Bus::count();
            //products
            $searchsuggest=LogViewProduct::SelectRaw("*, COUNT('id') as num")
                ->groupBy('cityid')
                ->groupBy('categoryid')
                ->orderBy('num','DESC')
                ->limit(6)
                ->get();
            View::share('shareddata',$data);
            View::share('searchsuggest',$searchsuggest);
        }
    }
}
