<?php

namespace App\Http\Controllers\Hotel\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Subpage;
use App\SubpagePhoto;
use App\HotelCompany;
use App\Photo;

use File;
use Intervention\Image\ImageManagerStatic as Image;
use ImageOptimizer;
use Carbon\Carbon;

class PartnerHotelSubpageController extends Controller
{
    //
    public function index(Request $req){
        $user=Auth::user();
        $data['buscompany']=$user->HotelCompanyPermission->first()->HotelCompany;        
        $data['subpage']=$data['buscompany']->Subpage->first();
        return view('partner.hotel.subpage')->with('data',$data);
    }
    public function postEdit(Request $req){
        $validateDate=$req->validate([            
            'hotelcomp'=>'required|exists:App\HotelCompany,id',
            'subpage'=>'nullable|exists:App\Subpage,id',

            'title'=>'required|string',
            'text'=>'nullable|string',
            'textArea2'=>'nullable|string',
            'mainPhoto'=>'',
            'photos'=>'',
            'photoDelete.*'=>'',//* Photo object id,
            ]);
        $now=now();
        $checknow=now();
        $subpage=Subpage::updateOrCreate([
            'id'=>$req->subpage??'',
            'hotel_companyid'=>$req->hotelcomp,
            ],[
                'title'=>$req->title,
                'text'=>$req->text,
                'text_area2'=>$req->textArea2,
                //'text_area3'=>
                //'data'
                'updated_at'=>$now,
            ]);
        /***
         * photo 
         * public/image/bus/subpage
         * **/

    /***
     * Main photo
     * **/
    if ($req->hasFile('mainPhoto')) {
          echo "true1";
         $files=$req->file('mainPhoto');
            $i=1;
            $path="image/bus/subpage";
            //foreach($files as $file){                
            $file=$files;
                $filenameWithExt = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $now=now();
                $fileNameToStore = $filename.$now.'a_'.time().$i.'.'.$extension;
                $file->move(public_path($path), $fileNameToStore);
                $i++;

                //ImageOptimizer::optimize(public_path('image/tour').'/'.$fileNameToStore );

                ImageOptimizer::optimize(public_path($path).'/'.$fileNameToStore, public_path($path).'/'.$fileNameToStore );
                Image::make(public_path($path).'/'.$fileNameToStore)->encode('jpg',65)
                  ->resize(1024, NULL, function ($constraint) {
                      $constraint->aspectRatio();
                  })
                  ->save(public_path($path).'/'.$fileNameToStore);

             //   print_r($r);
                $newphoto=Photo::create([
                  'name'=>$fileNameToStore,
                  'folder'=>$path,
                  'extension'=>$extension,
                  //'cityid'=>$city->id,
                  //'notes'=>'cover',
                  ]);
                SubpagePhoto::create([
                  'subpageid'=>$subpage->id,
                  'photoid'=>$newphoto->id,
                  'photo_group'=>0,
                    ]);
             // }
        }

        /***
         * 
         * Photos
         * **/
       if ($req->hasFile('photos')) {
          echo "true1";
         $files=$req->file('photos');
            $i=1;
            $path="image/bus/subpage";
            foreach($files as $file){                
                $filenameWithExt = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $now=now();
                $fileNameToStore = $filename.$now.'a_'.time().$i.'.'.$extension;
                $file->move(public_path($path), $fileNameToStore);
                $i++;

                //ImageOptimizer::optimize(public_path('image/tour').'/'.$fileNameToStore );

                ImageOptimizer::optimize(public_path($path).'/'.$fileNameToStore, public_path($path).'/'.$fileNameToStore );
                Image::make(public_path($path).'/'.$fileNameToStore)->encode('jpg',65)
                  ->resize(1024, NULL, function ($constraint) {
                      $constraint->aspectRatio();
                  })
                  ->save(public_path($path).'/'.$fileNameToStore);

             //   print_r($r);
                $newphoto=Photo::create([
                  'name'=>$fileNameToStore,
                  'folder'=>$path,
                  'extension'=>$extension,
                  //'cityid'=>$city->id,
                  //'notes'=>'cover',
                  ]);
                SubpagePhoto::create([
                  'subpageid'=>$subpage->id,
                  'photoid'=>$newphoto->id,
                  'photo_group'=>2,
                    ]);
              }
        }
        /***
         * 
         * 
         ****/
        if($req->photoDelete!=NULL && is_array($req->photoDelete)){
            foreach($req->photoDelete as $key=>$value){
                if($value==true){
                    $subpagePhoto=SubpagePhoto::where('photoid',$key)->first();
                    $photo=Photo::where('id',$key)->first();
                    if($subpagePhoto!=NULL){
                        $subpagePhoto->delete();
                        $path=public_path($photo->folder).'/'.$photo->name;    
                        unlink($path);
                    }
                }
            }
        }
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }
}
