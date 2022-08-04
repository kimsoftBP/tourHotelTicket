@extends('view')
@section('includecontent')

@endsection
@section('content')
<div class="col-10 col-lg-10" style="clear:both">
	
		<h5>{{$data['subpage']->title}}</h5>		
		<div>
			@php
				$mainphoto=$data['subpage']->SubpageMainPhoto??'';
			@endphp
			
			@if($mainphoto!=NULL  && isset($mainphoto->first()->Photo->folder))
				@php
					$mphoto=$mainphoto->first()->Photo;
				@endphp
				<img class="float-right" src="/{{$mphoto->folder??''}}/{{$mphoto->name??''}}" style="max-width: 300px; max-height: 300px;">
			@endif
		</div>
		<div>
			{{$data['subpage']->text??''}}
		</div>
		<div class="pt-2">
			{{$data['subpage']->text_area2}}
		</div>
	<div class="row" style="clear: both;">
		@foreach($data['subpage']->SubpageOtherPhoto as $subpagephoto)
            @php
             	$photo=$subpagephoto->Photo;
            @endphp
            	<div class="">
            		<img src="/{{$photo->folder}}/{{$photo->name}}" class="" style="max-width: 100%; max-height:200px" data-toggle="modal" data-target="#gallery">
            	</div>
            
		@endforeach
	</div>
</div>



<!-- Modal -->
<div class="col-12 p-0 modal fade" id="gallery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="col-12 p-0 m-0 modal-dialog" role="document" style="max-width: 100%!important;">
    <div class="col-12 p-0 modal-content" style="background-color:black">
      <div class="modal-header">        
        <button type="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">


        <div class="col-3 float-left modal-list" style="">        	
			        	<!--128*128 -->
			        	@php
			            $i=0;
			          @endphp
			          @foreach($data['subpage']->SubpageOtherPhoto as $subpagephoto)
			            @php
			             	$photo=$subpagephoto->Photo;
			            @endphp
			            <div class="float-left modal-list-photos" style="width:128px;height: 128px; rbackground-image: url('{{asset( $photo->folder.'/'.$photo->name )}}');" data-target="#carouselExampleIndicators" data-slide-to="{{$i}}">
			        	     <img data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class="m-1  d-block modal-list-photos modalgalleryimage float-left " src="{{asset( $photo->folder.'/'.$photo->name )}}" alt="First slide" style="max-width:128px; max-height: 128px;">
			            </div>
			            @php
			              $i++
			            @endphp
			        	@endforeach
			        </div>
			        <div class="col-9 float-left">
			        	
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			  <div class="carousel-inner ">
			    @php
			      $i=0;
			    @endphp
			    @foreach($data['subpage']->SubpageOtherPhoto as $subpagephoto)
			    	@php
			    		$photo=$subpagephoto->Photo;
			    	@endphp
			      <div class="carousel-item {{$i==0 ? 'active':''}}" style="text-align:center;">
			        <img class="d-block  modalgalleryimage" src="{{asset( $photo->folder.'/'.$photo->name )}}" alt="First slide" style="margin:auto;max-height: 700px;">
			      </div>
			      @php
			        $i++;
			      @endphp
			    @endforeach
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>





        </div>


      </div>      
    </div>
  </div>
</div>
@endsection