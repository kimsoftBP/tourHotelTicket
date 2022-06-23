<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\ProductPhoto;
use App\ProductChangeConfirmation; 
use App\Photo;
use App\Message;
use App\MessageType;
use Auth;

class ProductController extends Controller
{
    //
    public function ajaxproduct(Request $req){
      $msg="";
      try {
        
      

        $data['product']=Product::
            //where('checkadmin','!=',1)
            where('id',$req->id)
                //->where('title',$slug)
                ->first();
        
        $data['tomorrow']=date('Y-m-d',strtotime('1 days'));
        if($data['product']!=NULL){
          $msg=view('admin.ajaxproduct')->with('data',$data)->render();
        }else{
          $msg="error";
        }
      } catch (Exception $e) {
        
      }
      return response()->json(array('msg'=> $msg), 200);
    }
    public function index(Request $req){
        $user=Auth::user();
        $now=now();

    	$productspart=Product::                
                where('page1',1)
                ->where('page2',1)
                ->where('page3',1)
                ->where('remove',0)
                ->where(function($query2){
                    $query2->orWhere('checkadmin',0)
                        ->orWhereHas('photo',function($query){
                            $query->where('checkadmin',0);
                        })                        
                        ->orWhereHas('tourcourse',function($cquery){
                            $cquery->whereHas('photo',function($photoquery){
                                $photoquery->whereHas('photo',function($cpquery){
                                    $cpquery->where('checkadmin',0);
                                });
                            });
                        })
                        ->orWhereHas('meetingphoto',function($meetingquery){                            
                            $meetingquery->whereHas('photo',function($meetingcpquery){
                                $meetingcpquery->where('checkadmin',0);
                            });                            
                        })
                        ->orWhereHas('tourcourse',function($tquery){
                            $tquery->where('checkadmin',0);
                        })
                        //productchange
                        ->orWhereHas('confirmlog',function($pchange){
                            $pchange->whereNull('confirmbyuserid');
                        })
                        //tourcoursechange
                        ->orWhereHas('tourcourse',function($tcquery){
                            $tcquery->whereHas('log',function($logquery){
                                $logquery->whereNull('confirmbyuserid');
                            });
                        })
                        //ticket 
                        ->orWhereHas('ticket',function($ticketquery){
                            $ticketquery->where('checkadmin',0);
                        })
                        //ticket change
                        ->orWhereHas('ticket',function($tiquery){
                            $tiquery->whereHas('change',function($ticketchange){
                                $ticketchange->whereNull('confirmbyuserid');
                            });
                        });
                });

                //tourcourse
    	$limit=10;
    	//$data['page']=$req->page;
    	$page=$req->page;


        if(!$user->permadmin() ){
            if(!$user->permcontinentadmin()){
                $productspart->where(function($langquery) use($user){
                    $langquery->whereRaw('1!=1');//if foreach input null not have permission
                    foreach ($user->permissionLanguage as $row) {
                        $langquery->orWhereHas('language',function($lang) use($row){
                            $lang->where('languageid', $row->languageid);
                        });
                    }
                });
                $productspart->where(function($region) use($user){
                    $region->whereRaw('1!=1');//if foreach input null not have permission
                    foreach($user->permissionRegion as $row){
                        $region->orWhere('countryid',$row->countryid);
                    }
                });
            }else{
                /*continent admin limit region
                 */
                $productspart->where(function($region) use($user){
                    $region->whereRaw('1!=1');//if foreach input null not have permission
                    foreach($user->permissionRegion as $row){
                        $region->orWhereHas('country',function($country) use($row){
                            $country->whereHas('region',function($region)use ($row){
                                $region->where('continentid',$row->continentid);
                            });
                        });
                    }
                });
            }
        }


        /* pages
         */
        $cloneproduct=clone $productspart;
        $maxrows=$cloneproduct->count();
        $data['pages']=intdiv($maxrows,$limit);
        if( $maxrows%$limit !=0){
            $data['pages']++;
        }
        $data['page']=$page;
        if($data['page']>$data['pages']){
            $data['page']=$data['pages'];
        }
        $offset=($data['page']-1)*$limit;
        /* pages end
         */

        $data['url']="";


        
        $data['product']=$productspart->offset($offset)
                ->limit($limit)
                ->get();                
        return view('admin.product')->with('data',$data);
    }
    public function postconfirm(Request $req){
        $msg="";
    
        $msg.=$req->result;
        $msg.="<br>id ".$req->id;

        $user=Auth::user();
        $product=Product::where('id',$req->id)->first();

        /*
         * Have permission confirm product lang and region
         */
        $productspart=Product::where('id',$req->id);        
            
        if(!$user->permadmin() ){
            if(!$user->permcontinentadmin()){
                $productspart->where(function($langquery) use($user){
                    $langquery->whereRaw('1!=1');//if foreach input null not have permission
                    foreach ($user->permissionLanguage as $row) {
                        $langquery->orWhereHas('language',function($lang) use($row){
                            $lang->where('languageid', $row->languageid);
                        });
                    }
                });
                $productspart->where(function($region) use($user){
                    $region->whereRaw('1!=1');//if foreach input null not have permission
                    foreach($user->permissionRegion as $row){
                        $region->orWhere('countryid',$row->countryid);
                    }
                });
            }else{
                /*continent admin limit region
                 */
                $productspart->where(function($region) use($user){
                    $region->whereRaw('1!=1');//if foreach input null not have permission
                    foreach($user->permissionRegion as $row){
                        $region->orWhereHas('country',function($country) use($row){
                            $country->whereHas('region',function($region)use ($row){
                                $region->where('continentid',$row->continentid);
                            });
                        });
                    }
                });
            }
        }
        $p=$productspart->first();
        if($p==NULL){
            return redirect(404);
        }
        /*
         * Have permission end
         */



        //photo
        if($req->result!=NULL && $req->result=="accept"){
            //$msg.="<br>in if accept";
            Product::where('id',$req->id)->update(['checkadmin'=>1]);
            if(isset($req->d)){
                foreach ($req->d as $row) {
                    Photo::where('id',$row)->update(['checkadmin'=>1,'confirmbyuserid'=>$user->id]);
                    ProductPhoto::where('photoid',$row)->where('productid',$req->id)->update(['checkadmin'=>1]);
                 //   $msg.="<br>".$row;
                }
            }
        

            
            $change=$product->confirmlog->whereNull('confirmbyuserid')->first();     
            if($change!=NULL){            
                if($change->title!=NULL){
                    $product->title=$change->title;
                }
                if($change->onelinesummary!=NULL){
                    $product->onelinesummary=$change->onelinesummary;
                }
                if($change->introduction!=NULL){
                    $product->introduction=$change->introduction;
                }
                if($change->meetingplacename!=NULL){
                    $product->meetingplacename=$change->meetingplacename;
                }
                if($change->meetingplacecoordinate!=NULL){
                    $product->meetingplacecoordinate=$change->meetingplacecoordinate;
                }
                if($change->priceincluded!=NULL){
                    $product->priceincluded=$change->priceincluded;
                }
                if($change->notincluded!=NULL){
                    $product->notincluded=$change->notincluded;
                }
                if($change->essentialguidance!=NULL){
                    $product->essentialguidance=$change->essentialguidance;
                }
                $change->confirmbyuserid=$user->id;
                $change->save();
                $product->save();
            }
            foreach ($product->tourcourse as $row) {
                $row->checkadmin=1;
                
                $tourchange=$row->log->whereNull('confirmbyuserid')->first();
                if($tourchange!=NULL){
                    if($tourchange->title!=NULL){
                        $row->title=$tourchange->title;
                    }
                    if($tourchange->content!=NULL){
                        $row->content=$tourchange->content;
                    }
                    $tourchange->confirmbyuserid=$user->id;
                    $tourchange->save();
                }
                $row->save();
            }
            foreach ($product->ticket as $row) {
                $row->checkadmin=1;
                $up=$row->change->whereNull('confirmbyuserid')->first();
                if($up!=NULL){
                    if($up->title){
                        $row->title=$up->title;
                    }
                    if($up->shortdesc){
                        $row->shortdesc=$up->shortdesc;
                    }
                    $up->confirmbyuserid=$user->id;
                    $up->save();
                }
                $row->save();
            }
            
        }else{
            $msg.="if else denide";
            $product->admin_check_message=$req->text;            
            $product->save();

            

        }
        if($req->text!=NULL && $req->text!=""){
            $messagetype=MessageType::where('name','confirmation')->first();
            $message=Message::create([
                'text'=>$req->text,
                'fromuserid'=>$user->id,
                'productid'=>$product->id,
                'type'=>$messagetype->id,
                //'replybyid'=>
                ]);
        }
        /*if($req->d[22]!=NULL){
            $msg.="1";
        }*/
        //$msg.=$req->d[];
        //$msg.=count($req->d);
         return response()->json(array('msg'=> $msg), 200);   
    }
}
