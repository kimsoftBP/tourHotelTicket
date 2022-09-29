<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Continent;
use App\Region;
use App\City;
use App\Product;
use App\Advertising;
use App\AdvertisingFile;
use App\AdvertisingPosition;
use App\AdvertisingPositionInclude;

use File;
use Intervention\Image\ImageManagerStatic as Image;
use ImageOptimizer;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('permadmin');
    }

    public function advertising(Request $req){
        $validateDate=$req->validate([
            ]);

        $page=$req->page;
        $limit=10;
        if(!is_numeric($page) || $page<1){
            $page=1;
        }
        $data['page']=$page;
        //e
        //$data['page']=1;
        //$data['url']="";
        //$data['pages']="";
        $advertisingpart=Advertising::whereRaw('1 LIKE 1');

        $maxadvertising=clone $advertisingpart;
        $maxrows=$maxadvertising->count();
        $data['pages']=intdiv($maxrows,$limit);
        if( $maxrows%$limit !=0){
            $data['pages']++;
        }
        if($page>$data['pages']){$data['page']=$data['pages'];}
        $offset=($data['page']-1)*$limit;

        $data['advertising']=$advertisingpart->orderBy('created_at','DESC')->limit($limit)->offset($offset)->get();
        $data['position']=AdvertisingPosition::get();


        $data['url']="";
        //$data['url']="lang".$req->language."&country=".$req->country."&city=".$req->city;
        $data['advertisingposition']=AdvertisingPosition::get();
        return view('admin.advertising')->with('data',$data);
    }
    public function advertisingedit(Request $req){
        $validateDate=$req->validate([
            'advertising'=>'required|exists:App\Advertising,id',
            ]);
        $data['advertising']=Advertising::where('id',$req->advertising)->first();
        $data['position']=AdvertisingPosition::get();
        $html=view('admin.advertisingedit')->with('data',$data)->render();    
        return response()->json(array('msg'=> $html), 200);
    }
    public function advertisingpostedit(Request $req){
        $validateDate=$req->validate([
            'advertising'=>'required|exists:App\Advertising,id',
            'name'=>'required|string',
            'from'=>'required|date',
            'to'=>'nullable|date|after:from',

            'file.*'=>'nullable|max:10000|image|mimes:png,jpeg,jpg,gif,WebP',

            'position'=>'required|exists:App\AdvertisingPosition,id',
            'text'=>'required|string',
            'url'=>'nullable|url|active_url',
            ]);
/// nl2br(htmlspecialchars($ad_row->text,ENT_QUOTES) )
        //print_r($req->text);
        //$text_rows=substr_count( $req->text, "\n" );//not count emptry rows        
        $test=explode("\n", $req->text);
        $text_rows=count($test);//rows
        $ad_pos=AdvertisingPosition::where('id',$req->position)->first();
        $maxcolumn=30;
        $maxrows=9;
        if($ad_pos->text_max_columns!=NULL){
            $maxcolumn=$ad_pos->text_max_columns;
        }
        if($ad_pos->text_max_rows!=NULL){
            $maxrows=$ad_pos->text_max_rows;
        }
        

        $more=0;
        foreach($test as $row){
            $col=strlen($row);
            if($col>$maxcolumn){
                $i=intdiv($col,$maxcolumn);
                if($col%$maxcolumn!=0){
                    $i++;
                }
                $more+=$i;
            }
        }
        if($more+$text_rows>$maxrows){
            $errortext=str_replace(':rows',$maxrows, __('messages.textlimit') );
            $errortext=str_replace(':column',$maxcolumn,$errortext);
            $error = \Illuminate\Validation\ValidationException::withMessages([
               'text' => [$errortext],
               
            ]);            
            throw $error;
        }
        
        


        $advertising=Advertising::where('id',$req->advertising)->first();
        Advertising::where('id',$req->advertising)->update([
            'name'=>$req->name,
            'available_start'=>$req->from,
            'available_end'=>$req->to,
            'text'=>$req->text,
            'url'=>$req->url,
            ]);
        if($req->hasfile('file')){
            foreach($advertising->files as $adfile){                
                $deletepath=$adfile->path.$adfile->name;                
                $path=public_path($deletepath);
                $adfile->delete();                
                unlink($path);
            }  
      //     echo "file";
            $i=0;
            foreach ($req->file('file') as $ff) {                        
      //          echo "up";
                        $destinationPath='/image/advertising/';
                        $filenameWithExt = $ff->getClientOriginalName();
                        $extension = $ff->getClientOriginalExtension();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $fileNameToStore = $filename.'_'.$i.'_'.time().'.'.$extension;

                        $ff->move(public_path($destinationPath), $fileNameToStore);

                        ImageOptimizer::optimize(public_path($destinationPath).'/'.$fileNameToStore, public_path($destinationPath).'/'.$fileNameToStore );
                        Image::make(public_path($destinationPath).'/'.$fileNameToStore)->encode('jpg',65)
                          /*->resize(1024, NULL, function ($constraint) {
                              $constraint->aspectRatio();
                          })*/
                          ->save(public_path($destinationPath).'/'.$fileNameToStore);

                        AdvertisingFile::create([
                            'name'=>$fileNameToStore,
                            'path'=>$destinationPath,
                            'advertisingid'=>$advertising->id,
                            ]);
                $i++;            
            }
        }
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }
    public function advertisingadd(Request $req){
        $validateDate=$req->validate([
            'name'=>'required|string',
            'from'=>'required|date',
            'to'=>'nullable|date|after:from',
            'file.*'=>'nullable|max:10000|image|mimes:png,jpeg,jpg,gif,WebP',
            //dimensions:max_width=200,max_height=200            
            //'files.*'=>'max:10000|mimes:pdf,png,jpeg,jpg,csv,txt,zip,rar',
            'position'=>'required|exists:App\AdvertisingPosition,id',
            'text'=>'required|string',
            'url'=>'nullable|url',
            ]);
        $test=explode("\n", $req->text);
        $text_rows=count($test);//rows        
        $ad_pos=AdvertisingPosition::where('id',$req->position)->first();
        $maxcolumn=30;
        $maxrows=9;
        if($ad_pos->text_max_columns!=NULL){
            $maxcolumn=$ad_pos->text_max_columns;
        }
        if($ad_pos->text_max_rows!=NULL){
            $maxrows=$ad_pos->text_max_rows;
        }

        $more=0;
        foreach($test as $row){
            $col=strlen($row);
            if($col>$maxcolumn){
                $i=intdiv($col,$maxcolumn);
                if($col%$maxcolumn!=0){
                    $i++;
                }
                $more+=$i;
            }
        }
        if($more+$text_rows>$maxrows){
            $errortext=str_replace(':rows',$maxrows, __('messages.textlimit') );
            $errortext=str_replace(':column',$maxcolumn,$errortext);
            $error = \Illuminate\Validation\ValidationException::withMessages([
               'text' => [$errortext],
               
            ]);            
            throw $error;
        }
        $advertising=Advertising::create([
            'name'=>$req->name,
            'available_start'=>$req->from,
            'available_end'=>$req->to,
            'text'=>$req->text,
            'url'=>$req->url,
            ]);        
        AdvertisingPositionInclude::create([
            'advertisingid'=>$advertising->id,
            'advertisingpositionid'=>$req->position,
            ]);

        if($req->hasfile('file')){
     
            $i=0;
            foreach ($req->file('file') as $ff) {                        
                        $destinationPath='/image/advertising/';
                        $filenameWithExt = $ff->getClientOriginalName();
                        $extension = $ff->getClientOriginalExtension();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $fileNameToStore = $filename.'_'.$i.'_'.time().'.'.$extension;

                        $ff->move(public_path($destinationPath), $fileNameToStore);

                        ImageOptimizer::optimize(public_path($destinationPath).'/'.$fileNameToStore, public_path($destinationPath).'/'.$fileNameToStore );
                        Image::make(public_path($destinationPath).'/'.$fileNameToStore)->encode('jpg',65)
                          /*->resize(1024, NULL, function ($constraint) {
                              $constraint->aspectRatio();
                          })*/
                          ->save(public_path($destinationPath).'/'.$fileNameToStore);


                        AdvertisingFile::create([
                            'name'=>$fileNameToStore,
                            'path'=>$destinationPath,
                            'advertisingid'=>$advertising->id,
                            ]);
                $i++;            
            }
        }
        return redirect()->back()->with('success',__('messages.addcomplete'));
    }
    public function advertisingdelete(Request $req){
        $validateDate=$req->validate([
            'advertising'=>'required|exists:App\Advertising,id',
            ]);

        $advertising=Advertising::where('id',$req->advertising)->first();
        foreach($advertising->files as $adfile){                
            $deletepath=$adfile->path.$adfile->name;                
            $path=public_path($deletepath);
            $adfile->delete();                
            unlink($path);
        }  
        $advertising->delete();

        return redirect()->back()->with('success',__('messages.deletecompete'));
    }

    //
    public function index(){
    	return view('admin.view');
    }



}
