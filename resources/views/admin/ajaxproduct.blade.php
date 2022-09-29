<!--	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
  	function checkpost(result) {
   		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   		//var values = $("input[name='d[]']").map(function(){return $(this).val();}).get();
   		var values=[];
   		$("input:checkbox[name=d]:checked").each(function(){
		  values.push($(this).val());
		});
   		console.log(values);   	
   		$("#tablerow"+{{$data['product']->id}}).hide();
//   		console.log($("input[name='dtest[]']").val());
        $.ajax({
           type:'post',
           url:'/en/admin/product/confirm',
           data:{_token: CSRF_TOKEN, "id":{{$data['product']->id}},'result':result,'d':values,'text':$("#problem").val()
       			},
         //  data:'_token = <?php echo csrf_token() ?>',
           success:function(data) {
              $("#country2").html(data.msg);
           }
        });
     //   $('#exampleModal').modal('show');
    }

		/*
	function showgallery(photo){
		
		$('#exampleModal').modal('show');
	}*/
	function ticketn(ticket){
		db=$('#ticket-'+ticket).val();		
		db=parseInt(db)-1;
		if(db<0){
			db=0;
		}
		$('#ticket-'+ticket).val(db);
		$('#ticket-'+ticket+"-num").html(db);
	}
	function ticketp(ticket){
		db=$('#ticket-'+ticket).val();
		db=parseInt(db)+1;
		$('#ticket-'+ticket).val(db);
		$('#ticket-'+ticket+"-num").html(db);
	}
	//$('#gallerymodal').modal('show');
        function mydelete(id){
		
			if($("#d"+id).prop('checked')==true){
				$("#"+id).hide();
				//$("#d"+id).checked;
				$("#d"+id).prop('checked', false);
			//	$("#d"+id).val(0);
			}else{
				$("#"+id).show();
				//document.getElementById("#d"+id).checked =true;
				$("#d"+id).prop('checked', true);
				//$("#d"+id).val(true);
			}
		
		}
</script>
<style type="text/css">
	.offer-type-wrap {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 8;
}
</style>

<div class="col-lg-12 pl-lg-2 pr-lg-2" style="margin: auto;padding:0px;">
	<span class="bg-info p-2">{{__('messages.changecontentbg')}}</span>
	{{--<span class="bg-info p-2">{{__('messages.thisbackground')}}</span>--}}
	<div class="mt-5" style="margin-bottom: 30px; ">
		@php
			$cname="";

			if(($data['product']->city)!=NULL){
				$cityname=json_decode($data['product']->city->namearray,true);
				$loc=app()->getLocale();
				if(isset($cityname[$loc])){
					$cname=$cityname[$loc];
				}else{
					$cname=$data['product']->city->name;
				}
			}
			
			$changedproduct=$data['product']->confirmlog->whereNull('confirmbyuserid')->first();
			
		@endphp
		<div class="col-12 col-lg-12 float-left pl-lg-2 pr-lg-2" style="padding: 0px;">
			<!--<nav aria-label="breadcrumb">
			  <ol class="breadcrumb" style="background-color: transparent;">
			    <li class="breadcrumb-item active">{{$data['product']->country->name}}</li>
			    <li class="breadcrumb-item active" aria-current="page">
			    	@if($data['product']->city!=NULL)
			    	<a class="text-secondary" href="{{route('cities',['locale'=>app()->getLocale(),'slug'=>$data['product']->city->name])}}">{{$cname}}</a>
			    	@endif
			    </li>
			  </ol>
			</nav>
		-->
			<div>
				<h4><b>
					@php
						//print_r($data['product']->confirmlog->whereNull('confirmbyuserid')->first());
						//print_r($data['product']->confirmlog);
					@endphp						
					
					
					@if(isset($changedproduct->title) && $changedproduct->title!=NULL)
						<span class="bg-info">{{$changedproduct->title}}</span>
					@else
						{{$data['product']->title}}
					@endif
					
					
				</b></h4>
			</div>
			@php
				$feedback=$data['product']->feedbackstat();					
				$star="?";
				$num="?";
				if(isset($feedback->avgstar)){
					$star=$feedback->avgstar;
					$num=$feedback->num;
				}
				
		//		print_r( $product->avgfeedback() );
			@endphp
			<!--
			<div >
				<div class="text-primary float-left">
					@for($i=0;$i<=5;$i++)
						@if($i<$star)
							<i class="bi bi-star-fill"></i>
						@elseif($i>1 &&  ($i-0.5)<=($star) )
							<i class="bi bi-star-half"></i>
						@else
							<i class="bi bi-star fa-xs" style="font-size: 12px;"></i>
						@endif
					@endfor
					<span class="text-secondary"><b>{{round($star,1)}}</b>({{$num}})</span>
				</div>
				<div class="float-right">
					@if($data['product']->price->first()!=NULL)
					<h5>{{number_format($data['product']->price->first()->amount,0,","," ")}} {!!$data['product']->price->first()->currency->html!!}
						<small class="text-secondary">{{__('messages.perperson')}}</small>
					</h5>
					@endif
				</div>
			</div>
			<div style="clear:both;"></div>
-->
 <!--
			<div class="border-top col-12 mt-4 pt-4">
				<div>
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-2 float-left">					
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
						  <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
						</svg>
						{{__('messages.'.$data['product']->toursize->name)}}
					</div>
					<div class="col-6 p-2 float-left">
						<i class='fas fa-car' style='font-size:24px'></i>
						{{__('messages.'.$data['product']->vehicle->name)}}
					</div>
				</div>				
				<div>
					@if($data['product']->ticket->first() !=NULL && $data['product']->ticket->first()->eticket!=NULL)
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-2 float-left">
						<i class="bi bi-phone"></i>
						{{__('messages.eticket')}}
					</div>
					@endif
					<div class="col-12 col-sm-6 col-md-6 col-lg-6 p-2 float-left">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
						  <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"/>
						  <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"/>
						</svg>

							@if($data['product']->totalrequiredday > 0)
								<span>{{$data['product']->totalrequiredday}}</span>
							@endif

							@if($data['product']->totalrequiredhour > 0)
								<span>{{$data['product']->totalrequiredhour}}</span><span class="p-1" style="">{{__('messages.hour')}}</span>
							@endif

							@if($data['product']->totalrequiredminute > 0)
								<span>{{$data['product']->totalrequiredminute}}</span><span class="p-1">{{__('messages.minute')}}</span>
							@endif
						
					</div>
					<div class="col-6 p-2 float-left">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
						  <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z"/>
						  <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.94.31z"/>
						</svg>
						@foreach($data['product']->language as $language)
							{{$language->language->name}}
						@endforeach
					</div>
				</div>
			</div>		
			<div style="clear:both;"></div>
-->
			<div class="border-top pt-4 pb-4">{{-- galery --}}				
				<div style="">
					@php
						$i=0;
					@endphp
					<input type="hidden" name="dtest[]">
					<input type="hidden" name="dtest[]">
					<input type="hidden" name="dtest[]">
					<input type="hidden" name="dtest[]">
					@foreach($data['product']->photo as $photo)						
						@if($photo->checkadmin!=1)
							<div class="col-4 float-left pl-0 pt-1 pr-1" style="height: 200px;">
								<div class="property-entry h-100">	
									<div class="offer-type-wrap">       
							     		<span id="{{$photo->photo->id}}" class="offer-type bg-success" style="display: none;">{{__('messages.confirm')}}</span>					     		
							     	</div>
									<img class="d-block w-100" src="{{$photo->photo->folder}}/{{$photo->photo->name}}" alt="Second slide" style="max-height: 120px;" onclick="mydelete({{$photo->photo->id}})">
									<!--{{--
									<input type="checkbox" id="d{{$photo->photo->id}}" name="d[{{$photo->photo->id}}]" value="{{$photo->photo->id}}">
									--}}-->
									<input type="checkbox" id="d{{$photo->photo->id}}" name="d" value="{{$photo->photo->id}}" class="">
								</div>
							</div>





						@endif
					@endforeach
				</div>
			</div>
			<div style="clear: both;"></div>
			<div class="border-top mt-4 pt-4 pb-4" id="reservation">{{-- choose an option --}}
				<!--<span><h5><b>{{__('messages.chooseanoption')}}</b></h5></span>
				<div class="input-group mb-3">
					<input type="date" class="form-control" name="date" min="{{$data['tomorrow']}}">
					<input type="number" class="form-control" name="person" min="0">
					<div class="input-group-append">
						<button class="btn btn-primary">{{__('messages.updateamount')}}</button>
						{{--<span class="input-group-text"></span>--}}
					</div>
				</div>
			-->
				<div>
					@foreach($data['product']->ticket as $ticket)
						<div class="col-12 shadow p-3 mb-5 bg-white rounded" style="clear: both;box-sizing: border-box;">
							<div class="col-6 float-left" style="display:table-cell;  ">
								<h5>
									@php
										$tempchange=$ticket->change->whereNull('confirmbyuserid')->first();
									@endphp
									@if($tempchange!=NULL && $tempchange->title!=NULL)
										<span class="bg-info p-1">
											{{$tempchange->title}}
										</span>
									@else
										{{$ticket->title}}
									@endif

									
								</h5>
								@php									
									$tshortdeschigh=0;									
									if($tempchange!=NULL && $tempchange->shortdesc!=NULL){
										$tshortdeschigh=1;
									}
								@endphp
								<span class="text-secondary {{$tshortdeschigh ? 'bg-info p-1':''}}">
									@if($tshortdeschigh)
										{{$tempchange->shortdesc}}
									@else
										{{$ticket->shortdesc}}
									@endif
								</span>
							</div>
							<div class="col-3 float-left" style="display:table-cell; ">
								{{$ticket->price}}{!! $ticket->currency->html !!}
							</div>
							<div class="col-3 float-left2" style="display:table-cell; white-space: nowrap;">
								
								<button class="btn btn-outline-primary " type="button" onclick="ticketn({{$ticket->id}})" disabled>-</button>
								<span id="ticket-{{$ticket->id}}-num">0</span>
								<button class="btn btn-outline-primary" disabled type="button" onclick="ticketp({{$ticket->id}})">+</button>
							
								<input type="hidden" name="ticket[][0]" value="{{$ticket->id}}">
								<input type="hidden" name="ticket[][1]" id="ticket-{{$ticket->id}}" value="0">
							</div>
							<div style="clear: both;">
							</div>
						</div>
					@endforeach
				</div>
				<div>
					<div>

					</div>
					<div class="text-right">
						{{__('messages.totalamount')}}						
						<span>364</span>
					</div>
					<div class="text-right">
						<button class="btn btn-primary" disabled>{{__('messages.')}}</button>
					</div>
				</div>
			</div>
			<div class="pt-4 pb-4">
				<span>
					<h5>
						@if(isset($changedproduct->onelinesummary) && $changedproduct->onelinesummary!=NULL)
						<span class="bg-info p-1">{{$changedproduct->onelinesummary}}</span>
						@else
							{{$data['product']->onelinesummary}}
						@endif						
					</h5>
				</span>
			</div>
			<div>				
				@if(isset($changedproduct->introduction) && $changedproduct->introduction!=NULL)
					<div class="bg-info p-1">
						{!! nl2br(htmlspecialchars($changedproduct->introduction,ENT_QUOTES) ) !!}
					</div>
				@else
					{!! nl2br(htmlspecialchars($data['product']->introduction,ENT_QUOTES) ) !!}
				@endif
			</div>
			<div>{{--reviews --}}
			</div>
			<div>{{--other tour in this city --}}
			</div>
			<div class="border-top pt-4 pb-4">
				<h4 class="pb-4"><b>{{__('messages.productinformation')}}</b></h4>
				<h5 class=""><b>{{__('messages.included')}}</b></h5>
				{{$data['product']->priceincluded}}
				<h5 class="pt-4"><b>{{__('messages.notincluded')}}</b></h5>
				{{$data['product']->notincluded}}
			</div>
			<div class="border-top pt-4 pb-4">
				<h4>{{__('messages.courseintroduction')}}</h4>
				<div>					
					@foreach($data['product']->tourcourse as $course)
						<div class="p-3 {{$course->checkadmin==0 ? 'bg-info':''}}"  style="min-height: 250px;">
							<div>
								<i class="bi bi-geo-alt-fill"></i>
								<b>
									@if($course->log->whereNull('confirmbyuserid')->first()!=NULL && $course->log->whereNull('confirmbyuserid')->first()->title!=NULL)
										<span class="bg-info p-1">{{$course->log->whereNull('confirmbyuserid')->first()->title}}
										</span>
									@else
										{{$course->title}}
									@endif
								</b>
								<small>
									@if($course->hour>0)
										{{$course->hour}} {{__('messages.hour')}}
									@endif
									@if($course->minute>0)
										{{$course->minute}} {{__('messages.minute')}}
									@endif
								</small>
							</div>
							<div class="pl-3 p-2 " style="border-left: 2px solid; margin-left: 5px;">					
								
								@if(($course->photo->first())!=NULL)	
									@php
										$cphoto=$course->photo->first()->photo;
									@endphp						
								<div class="float-lg-right bg-white float-md-right">
									<div class="2offer-type-wrap" style="position: relative; height:0px; top: 10px;left: 10px;">       
							     		<span id="{{$course->photo->first()->photo->id}}" class="2offer-type bg-success" style="display: none;">{{__('messages.confirm')}}</span>					     		
							     	</div>
									<img src="{{$course->photo->first()->photo->folder}}/{{$course->photo->first()->photo->name}}" style="max-height: 250px;max-width: 250px;" class=""  onclick="mydelete({{$cphoto->id}})">
									@if($cphoto->checkadmin)
									@else
										<span class="bg-info p-2">
											<input type="checkbox" id="d{{$course->photo->first()->photo->id}}" name="d" value="{{$course->photo->first()->photo->id}}">
										</span>
									@endif
								</div>
								@endif

								@if($course->log->whereNull('confirmbyuserid')->first()!=NULL && $course->log->whereNull('confirmbyuserid')->first()->content!=NULL)
									<span class="bg-info p-1">{{$course->log->whereNull('confirmbyuserid')->first()->content}}
										</span>
								@else
									{{$course->content}}							
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<div class="border-top pt-4 pb-4">
				<h4>{{__('messages.informationuse')}}</h4>
				<h6><b>{{__('messages.meetingtime')}}</b></h6>
				<span>{{$data['product']->meetingtime}}</span>
				<h5><b>{{__('messages.meetingplace')}}</b></h5>
				<span>{{$data['product']->meetingplacename}}</span>


				@php
					$img="";
					$mphoto=NULL;
					$mpid=NULL;

					if($data['product']->meetingphoto->first() !=NULL){
						$photo=$data['product']->meetingphoto->first()->photo;
						$mpid=$photo->id;
						$img=$photo->folder."/".$photo->name;				
						$mphoto=$photo->checkadmin;
					}	
				@endphp		
				{{$mpid}}		
				<br>
				<div>					
					
						<div class="2offer-type-wrap" style="position: relative; height:0px; top: 10px;left: 10px;">
				     		<span id="{{$mpid}}" class="2offer-type bg-success" style="display: none;">{{__('messages.confirm')}}</span>					     		
				     	</div>
			     	@if($mpid!=NULL)
						<img src="{{$img}}" class="img-fluid" alt="{{__('messages.meetingplace')}}" style="max-width: 400px;max-height: 200px;" onclick="mydelete({{$mpid}})">

						@if($mphoto)
						@else
						<span class="bg-info p-2">
							<input type="checkbox" class="" id="d{{$mpid}}" name="d" value="{{$mpid}}">
						</span>
						@endif
					@endif
				</div>
				<div class="pt-2">
					<h5><b>{{__('messages.essentialguidance')}}</b></h5>
					{{$data['product']->essentialguidance}}
				</div>
					
			</div>
			
		</div>
		
		
	</div>
	<div style="clear: both;"></div>
	<div class="border-top border-dark">		
		@if($data['product']->confirmmessage->first() !=NULL)
			@php
				$temp=$data['product']->confirmmessage->first();
			@endphp
			<div class="col-12 mt-3 {{$temp->fromuserid==$data['product']->userid ? 'text-right':''}} border p-3">
				<span class="bg-secondary p-1 mw-75 text-white"> 
					{{$temp->text}}
				</span>
			</div>
		@endif
		<div class="mt-2 mb-3 col-10">

    		<textarea class="form-control" id="problem" name="problem"></textarea>
    		<button type="button" class="btn btn-danger" onclick="checkpost('denide')">X</button>
    		<button type="button" class="btn btn-success" onclick="checkpost('accept')">{{__('messages.confirm')}}</button>
    	</div>
    </div>
</div>

<style type="text/css">
	.modal-bottom {
   position:fixed Important; 
   top:auto;
  /* right:auto;
   left:auto;*/
   bottom:0;
}
</style>

<!-- gallery -->
<div class="modal modal-bottom2 fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
  	 <div class="modal-content h100" style="max-height: 700px;background-color: transparent;border: none;">
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators">
		   <!-- <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		    <li data-target="#carouselExampleIndicators" data-slide-to="2" ></li>
		-->
		    @php $j=0; @endphp
		    @foreach($data['product']->photo as $photo)		  		
		    	<li data-target="#carouselExampleIndicators" data-slide-to="{{$j}}" >
		    	{{--<img class="d-block w-100" src="{{$photo->photo->folder}}/{{$photo->photo->name}}" style="max-height: 60px;" >	--}}
		    	</li>
		    	@php $j++; @endphp
		    @endforeach
		  </ol>
		  <div class="carousel-inner text-center">	
		  	@php
		  		$k=0;
		  	@endphp	  	
		  	@foreach($data['product']->photo as $photo)		  		
			    <div id="gallery{{$photo->id}}" class="carousel-item {{$k==0 ? 'active':''}}">
			      <img class=" img-fluid" src="{{$photo->photo->folder}}/{{$photo->photo->name}}" alt="First slide" style="max-height: 500px;">
			    </div>
			    @php $k++;  @endphp
			@endforeach
		    <!--
		    <div class="carousel-item">
		      <img class="d-block w-100" src="/image/Budapest.jpg" alt="Second slide">
		    </div>
		    <div class="carousel-item " >
		      <img class="d-block w-100" src="/image/banner-item-null2.jpg" alt="Third slide">
		    </div>-->
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
  	<!--
   
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
   
-->

 	</div>
  </div>
</div>
