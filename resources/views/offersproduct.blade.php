@extends('view')
@section('includecontent')
<title>{{$data['product']->title}} {{__('page.offersproducttitle')}}</title>
<meta property="og:title" content="{{__('page.offersproducttitle')}}" />
<meta property="og:description" content="{{$data['product']->title}} | {{__('messages.'.$data['product']->country->name)}} | {{__('messages.offersproductdescription')}}" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:site_name" content="{{__('page.sitename')}}" />
<meta name="robots" content="index, follow" />

<style type="text/css">
	@media only screen and (max-width:600px){
		.carouselmobile{

		}
		.carouseldesktop{
			display: none;
		}
	}
	@media only screen and (min-width:600px){
		.carouselmobile{
			display: none;
		}
	}

	/* desktop */
	.cardcustom{
		background-position: center;
		background-repeat: no-repeat !important;
		width: 252px;
		height: 334px;
		/*
		max-width: 252px;
		*/
		max-height:334px;
		/*height: 100%;*/
		border-radius: 10px;

		background-color:rgba(0,0,0,.7);
/*
		background-image: linear-gradient(142deg,rgba(0,0,0,.7),hsla(0,0%,100%,0) 65%); 
		*/
		color:white;
	}
	.shadow {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
</style>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">

<script type="text/javascript">
	function showgallery(photo){
		
		$('#exampleModal').modal('show');
	}
	function changeperson(perperson){
		person=$("#person").val();
		

		ticketprice=$("#ticketprice").val()
		resz=person*perperson;
		sum=Number(resz)+Number(ticketprice);

		$("#totalamount").html(sum);
		$("#personprice").val(resz);
	}
	function ticketn(ticket,price){
		db=$('#ticket-'+ticket).val();		
		db=parseInt(db)-1;
		i=0
		if(db<0){
			db=0;
			i=1;
		}
		$('#ticket-'+ticket).val(db);
		$('#ticket-'+ticket+"-num").html(db);

		if(i==0){
			ticketprice=$("#ticketprice").val()
			productprice=$("#personprice").val();
			tprice=Number(ticketprice)-Number(price);
			console.log(tprice);
			$("#ticketprice").val(tprice);
			$("#totalamount").html(Number(tprice)+Number(productprice));		
		}
	}
	function ticketp(ticket,price){
		db=$('#ticket-'+ticket).val();
		db=parseInt(db)+1;
		$('#ticket-'+ticket).val(db);
		$('#ticket-'+ticket+"-num").html(db);

		ticketprice=$("#ticketprice").val()
		productprice=$("#personprice").val();
		tprice=Number(ticketprice)+Number(price);
		console.log(tprice);
		$("#ticketprice").val(tprice);
		$("#totalamount").html(Number(tprice)+Number(productprice));
	}
	//$('#gallerymodal').modal('show');
</script>
{{-- test gallery --}}


{{--test gallery --}}

 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
	jQuery(function(){ 
    var enableDays = [""];
    @if($data['product']->availableUi->first()!=NULL )
    	var enableDays=[
    	@foreach($data['product']->availableUi->first()->availableAfterTodayHaveTicket() as $a_row)
    		"{{$a_row->date}}",
    	@endforeach
    		];
   	@endif
    function enableAllTheseDays(date) {
        var sdate = $.datepicker.formatDate( 'yy-mm-dd', date)
        console.log(sdate)
        if($.inArray(sdate, enableDays) != -1) {
            return [true];
        }
        return [false];
    }  
    $('#datepicker').datepicker({dateFormat: 'yy-mm-dd', beforeShowDay: enableAllTheseDays});
})
</script>


@endsection
@section('content')
<div class="col-lg-10 pl-lg-2 pr-lg-2" style="margin: auto;padding:0px;">
		@if (\Session::has('success'))
		<div class="alert alert-success">
			<ul>
				<li>{!! \Session::get('success') !!}</li>
			</ul>
		</div>
		@endif
		@if (\Session::has('error'))
		<div class="alert alert-danger">
			<ul>
				<li>{!! \Session::get('error') !!}</li>
			</ul>
		</div>
		@endif
				
		@if($errors->any())
			<div class="alert text-danger">
				{{ implode('', $errors->all(':message')) }}
			</div>
		@endif

	
	<div class="" style="margin-bottom: 30px; ">
		@php
			$cname="";

			if(isset($data['product']) && ($data['product']->city)!=NULL){
				$cityname=json_decode($data['product']->city->namearray,true);
				$loc=app()->getLocale();
				if(isset($cityname[$loc])){
					$cname=$cityname[$loc];
				}else{
					$cname=$data['product']->city->name;
				}
			}
		@endphp
		<div class="col-12 col-lg-8 float-left pl-lg-2 pr-lg-2" style="padding: 0px;">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb" style="background-color: transparent;">
			    <li class="breadcrumb-item active">{{__('messages.'.$data['product']->country->name)}}</li>
			    @if(isset($data['product']->city))
				    <li class="breadcrumb-item active" aria-current="page">
				    	<a class="text-secondary" href="{{route('cities',['locale'=>app()->getLocale(),'slug'=>$data['product']->city->name])}}">{{$cname}}</a>
				    </li>
				@endif
			  </ol>
			</nav>
			<div>
				<h4><b>
					{{$data['product']->title}}
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
			<div style="clear:both;">
				<div class="border-top pt-3" style="font-size: 1.2rem">
					<i class="bi bi-person-circle"></i>
					{{$data['product']->user->name}}
				</div>
			</div>


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
								<span class="p-1">{{__('messages.day')}}</span>
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


			<meta property="og:type" content="tour">
			<meta property="og:url" content="{{url()->current()}}">
			<meta property="og:title" content="{{$data['product']->meta_title}}">
			<meta property="og:site_name" content="{{env('APP_NAME')}}">
			<meta property="og:description" content="{{$data['product']->meta_description}}">
			<meta property="og:image" content="">

	<meta property="product:pretax_price:amount" content="{{$data['product']->price->first()->amount}}">
    <meta property="product:pretax_price:currency" content="{{$data['product']->price->first()->currency->code}}">
    <meta property="product:price:amount" content="{{$data['product']->price->first()->amount}}">
    <meta property="product:price:currency" content="{{$data['product']->price->first()->currency->code}}">
	<meta itemprop="priceCurrency" content="{{$data['product']->price->first()->currency->code}}">	
	@php
		$metaimage=$data['product']->photo->where('checkadmin',1)->first()
	@endphp	
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Tour",
            "name": "{{$data['product']->meta_title}}",
            "category": "Tour",
            @if(isset($metaimage->photo) && $metaimage!=NULL)
            "image": "{{asset($metaimage->photo->folder."/".$metaimage->photo->name )}}",
            @endif
            "description": "{{$data['product']->meta_description}}",
            
            "offers": {
                "@type": "Offer",
                "priceCurrency": "{{$data['product']->price->first()->currency->code}}",
                "price": "{{$data['product']->price->first()->amount}}",
                "availability": "https://schema.org/InStock",
                "seller": {
                    "@type": "Organization",
                    "name": "{{$data['product']->user->name}}"
                }
            }
        }
    </script>


			<div class="border-top pt-4 pb-4">{{-- galery --}}				
				<div style="">
					@php
						$i=0;
					@endphp
					@foreach($data['product']->photo as $photo)
						@if($photo->checkadmin)
							@if($i==0)							
								<img class="d-block r-w-100" src="{{$photo->photo->folder}}/{{$photo->photo->name}}" alt="Second slide" onclick="showgallery({{$photo->photo->id}})" style="max-height: 450px; max-width: 100%;">
							@else
								<div class="col-4 float-left pl-0 pt-1 pr-1" style="height: 200px;">
									<img class="d-block r-w-100" src="{{$photo->photo->folder}}/{{$photo->photo->name}}" alt="Second slide" style="max-height: 200px;max-width: 100%;">
								</div>
							@endif

							@php
							//$photo->folder."/".$photo->name 
								$i++; 
								if($i>3){
									break;
								}
							@endphp				
						@endif		
					@endforeach
				</div>
			</div>
			<div style="clear: both;"></div>

			<!-- reservation form-->
			<form action="{{route('reservation',app()->getLocale())}}" method="POST">
				@csrf
				<div class="border-top mt-4 pt-4 pb-4" id="reservation">{{-- choose an option --}}
					<span><h5><b>{{__('messages.chooseanoption')}}</b></h5></span>

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="bi bi-calendar-event-fill"></i></span>
						</div>
						<input type="hidden" name="product" value="{{$data['product']->id}}">
						@php
							$tempprice=0;
						@endphp
						@if($data['product']->price->first()!=NULL)
							@php
								$tempprice=number_format($data['product']->price->first()->amount,0,",","");
							@endphp
						@endif

@if($data['product']->availableUi->first()==NULL)
						<input type="date" class="form-control @error('date') is-invalid @enderror" name="date" min="{{$data['tomorrow']}}" value="{{old('date')}}">

						
						
							
@else
	<input  id="datepicker" class="form-control @error('date') is-invalid @enderror"  name="date" />
		<div class="input-group-append">
			<span class="input-group-text"><i class="bi bi-clock-fill"></i></span>
		</div>
		<select name="time" class="form-control @error('time') is-invalid @enderror">
			@foreach(json_decode( $data['product']->availableUi->first()->hour ,true) as $row)
				<option value="{{$row}}">{{$row}}</option>
			@endforeach
		</select>
@endif	
						<div class="input-group-append">
							<span class="input-group-text"><i class="bi bi-person-fill"></i></span>
						</div>	
						<input type="number" id="person" class="form-control @error('person') is-invalid @enderror" name="person" min="0" placeholder="{{__('messages.numberofpeople')}}" onchange="changeperson({{$tempprice}})" value="{{old('person')}}">

						<!--<div class="input-group-append">
							<button class="btn btn-primary">{{__('messages.updateamount')}}</button>
							{{--<span class="input-group-text"></span>--}}
						</div>-->
						
					</div>	
					<div>
						<div class="col-6 float-left">
							@error('date')
									<div class="text-danger"> 
										{{ $message }}
									</div>
							@enderror		
						</div>
						<div class="col-6 float-left">
							@error('person')
									<div class="text-danger"> 
										{{ $message }}
									</div>
							@enderror
						</div>
					</div>
					<div>
						@foreach($data['product']->ticket as $ticket)
							<div class="col-12 shadow p-3 mb-5 bg-white rounded" style="clear: both;box-sizing: border-box;">
								<div class="col-6 float-left" style="display:table-cell;  ">
									<h5>{{$ticket->title}}</h5>
									<span class="text-secondary">
										{{$ticket->shortdesc}}
									</span>
								</div>
								<div class="col-3 float-left" style="display:table-cell; ">
									{{$ticket->price}}{!! $ticket->currency->html !!}
								</div>
								<div class="col-3 float-left2" style="display:table-cell; white-space: nowrap;">
									<button class="btn btn-outline-primary" type="button" onclick="ticketn({{$ticket->id}},{{$ticket->price}})">-</button>
									<span id="ticket-{{$ticket->id}}-num">0</span>
									<button class="btn btn-outline-primary" type="button" onclick="ticketp({{$ticket->id}},{{$ticket->price}})">+</button>
									<input type="hidden" name="ticketid[]" value="{{$ticket->id}}">
									<input type="hidden" name="ticket[]" id="ticket-{{$ticket->id}}" value="0">
								</div>
								<div style="clear: both;">
								</div>
							</div>
						@endforeach
					</div>
					<div>
						<div>

						</div>
						<input type="hidden" id="ticketprice" name="ticketprice" value="0">
						<input type="hidden" id="personprice" name="personprice" value="0">
						<div class="text-right">
							{{__('messages.totalamount')}}						
							<span id="totalamount"></span> 
						</div>
						<div class="text-right">
							<button class="btn btn-primary">{{__('messages.reservation')}}</button>
						</div>
					</div>
				</div>
			</form>
			<!--- form -->

			<div class="pt-4 pb-4">
				<span>
					<h5>{{$data['product']->onelinesummary}}</h5>
				</span>
			</div>
			<div>				
				{!! nl2br(htmlspecialchars($data['product']->introduction,ENT_QUOTES) ) !!}
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
						@if($course->checkadmin)
							<div class="p-3" style="/*min-height: 250px;*/">
								<div>
									<i class="bi bi-geo-alt-fill"></i>
									<b>{{$course->title}}</b>
									<small>
										@if($course->hour>0)
											{{$course->hour}} {{__('messages.hour')}}
										@endif
										@if($course->minute>0)
											{{$course->minute}} {{__('messages.minute')}}
										@endif
									</small>
								</div>
								<div class="pl-3 p-2 " style="border-left: 2px solid; margin-left: 5px; 
									@if(($course->photo->first())!=NULL && $course->photo->first()->photo->checkadmin)
										min-height: 250px;
									@endif
									">					
									
									@if(($course->photo->first())!=NULL && $course->photo->first()->photo->checkadmin)															
										<div class="float-lg-right float-md-right">
											<img src="{{$course->photo->first()->photo->folder}}/{{$course->photo->first()->photo->name}}" style="max-height: 250px;max-width: 250px;" class="">
										</div>
									@endif
									{{$course->content}}							
								</div>
							</div>
						@endif
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
					if($data['product']->meetingphoto->first() !=NULL && $data['product']->meetingphoto->first()->photo->checkadmin){
						$photo=$data['product']->meetingphoto->first()->photo;

						$img=$photo->folder."/".$photo->name;				
					}	
				@endphp				
				<br>
				@if($img!="")
				<img src="{{$img}}" class="img-fluid" alt="{{__('messages.meetingplace')}}" style="max-width: 400px;max-height: 200px;">
				@endif
				<div class="pt-2">
					<h5><b>{{__('messages.essentialguidance')}}</b></h5>
					{{$data['product']->essentialguidance}}
				</div>
					
			</div>
			
		</div>
		
		<div class="float-left col-12 col-lg-4">
			<div class="2position-sticky  position-fixed border col-lg-3 p-4" style="">
				<div class="pb-2">

					@if($data['product']->price->first()!=NULL)		

						<h5>{{number_format($data['product']->price->first()->amount,0,","," ")}} {!!$data['product']->price->first()->currency->html!!}
							<small class="text-secondary">{{__('messages.perperson')}}</small>
						</h5>
						<div class="border-top">
							@foreach($data['product']->price as $productprice)
								{{$productprice->minimumpeople}}-{{$productprice->maximumpeople}}
								<span>{{$productprice->amount}} {!! $productprice->currency->html !!}</span>
							@endforeach
						</div>
					@endif
				</div>	
				<div class="border-top pt-3 pb-3">					
					<a class="col-12 btn btn-primary" href="#reservation">{{__('messages.makeareservation')}}</a>
					<br><button class="col-12 mt-2 btn btn-white" disabled="">
						<i class="bi bi-heart"></i>
						{{__('messages.addtowishlist')}}</button>
				</div>			
				<div class="border-top pt-3" style="font-size: 1.2rem">
					<i class="bi bi-person-circle"></i>
					{{$data['product']->user->name}}
					<a href=""><i class="bi bi-envelope"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>
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
		    @foreach($data['product']->photo->where('checkadmin',1) as $photo)		  	

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
		  	@foreach($data['product']->photo->where('checkadmin',1) as $photo)		  		
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

	@endsection