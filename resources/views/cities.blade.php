@extends('view')
@section('includecontent')
	@php
			$cityname=json_decode($data['city']->namearray,true);
			$cname="";
			$loc=app()->getLocale();
			if(isset($cityname[$loc])){
				$cname=$cityname[$loc];
				
			}else{
				$cname=$data['city']->name;
				
			}
	@endphp
<title>{{$cname}} {{__('page.citiestitle')}}</title>
<meta property="og:title" content="{{__('page.citiestitle')}}" />
<meta property="og:description" content="{{__('page.citiesdescription')}}" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:site_name" content="{{__('page.sitename')}}" />
<meta name="robots" content="index, follow" />

<style type="text/css">
	.citybackground{
		/*background-image: linear-gradient(142deg,rgba(0,0,0,.7),hsla(0,0%,100%,0) 65%);*/
		@php 
			$img="";
			$city=$data['city'];
		@endphp
		@if(NULL!=( $city->photos()->where('notes','cover')->first()) )
			@php
				$photo=$city->photos()->where('notes','cover')->first();
				$img=$photo->folder."/".$photo->name;
			@endphp
		@endif
		background-image: url('{{$img}}');
		 background-position: center;
		background-repeat: no-repeat !important;
		/*
		background-color: rgba(0,0,0,.4);*/
	}
	.citybackgroundgray{
		background-color: rgba(0,0,0,.4);
	}
	.bg-light{
		background-color: transparent!important;
		color:white;
	}
	.citiesnavbar{
		color: white !important;
		font-weight: bold !important;
	}
	.category-button {
	    display: inline-flex;
	    -webkit-box-pack: start;
	    justify-content: flex-start;
	    -webkit-box-align: center;
	    align-items: center;
	    background-color: #f5f6f7;
	    color: #343a40;
	    font-weight: 500;
	    letter-spacing: -0.4px;
	    height: 48px;
	    font-size: 16px;
	    width: 100%;
	    border-width: initial;
	    border-style: none;
	    border-color: initial;
	    border-image: initial;
	    border-radius: 4px;
	    padding: 12px 16px 12px 12px;
	}
	.linelimit {
		max-height: 3rem;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
	}
</style>

@endsection
@section('contentbgimg')
<div class="text-white" style="padding-bottom: 100px;padding-top: 100px;">
	<div class="d-flex justify-content-center" style="margin: auto;">
		{{--
		<h1 class="font-weight-bold">{{$data['slug']}}</h1>
		--}}
		<h1 class="font-weight-bold">
		@php
			$cityname=json_decode($data['city']->namearray,true);
			$cname="";
			$loc=app()->getLocale();
			if(isset($cityname[$loc])){
				$cname=$cityname[$loc];
				echo $cityname[$loc];
			}else{
				$cname=$data['city']->name;
				echo $data['city']->name;
			}
	 	@endphp
	 	</h1>
	</div>
</div>
@endsection
@section('content')
<div class="">
	<div class="col-lg-10 row" style="padding: auto;margin: auto;padding: 0px">
		<div style="">
			<h4>
			<span>{{__('messages.category')}}</span>
			</h4>
			<div class="text-left" style="">
				@foreach($data['category'] as $category)			
					<button class="btn btn-light btn-sm  col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 text-left float-left" style="">
						<span><img src="/img/{{$category->iconfilename}}" height="30px"></span>
						<span>{{$category->name}}</span>
					</button>
				
				@endforeach
			</div>
		</div>


		<div id="carouseladv" class="carousel slide carouseldesktop" data-ride="carousel" style="padding-top: 60px">
			<div class="carousel-inner">
				@php
					$i=0;
				@endphp				
				{{--
				@foreach($data['city']->products as $product)
				--}}
				@foreach($data['products'] as $product)
					@php
						$k=$i;
					@endphp

					@if($i%4==0)
						@if($i!=0)
									</div>
							 	</div>
							</div>
						@endif
							<div class="carousel-item {{$i==0 ? 'active':''}}">
								<div class="card-deck">								
									<div class="card-deck" >
					@endif
								<!--<img class="d-block w-100" src="..." alt="First slide">-->
								<a href="{{route('offers.product',['locale'=>app()->getLocale(),'slug'=>$product->title])}}">
								<div class="card" style="width: 18rem;">
									@php									
										$pphoto=$product->photo->where('checkadmin',1)->first();
										$im="/img/default.png";
										if($pphoto!=NULL && $pphoto->checkadmin){
											$im=$pphoto->photo->folder."/".$pphoto->photo->name;
										}
									@endphp
									@if($im!="")
									<img class="card-img-top" src="{{$im}}" alt="Card image cap" style="max-height: 170px ">
									@endif
									<div class="card-body" style="height: 170px;">
										<span class="card-text">
											<small class="text-muted2">{{__('messages.'.$product->category->name)}}</small>
											<small class="text-muted2">
												{{$cname}}
											</small>
										</span>
										<h5 class="card-title linelimit">{{$product->onelinesummary}}</h5>

										@php
											$feedback=$product->feedbackstat();					
											$star="?";
											$num="?";
											if(isset($feedback->avgstar)){
												$star=$feedback->avgstar;
												$num=$feedback->num;
											}
										@endphp
										<div class="{{$num!='?' ? 'text-primary':'text-secondary'}} ">
											@for($i=0;$i<=5;$i++)
												@if($i<$star)
													<i class="bi bi-star-fill"></i>
												@elseif($i>1 &&  ($i-0.5)<=($star) )
													<i class="bi bi-star-half"></i>
												@else
													<i class="bi bi-star"></i>
												@endif
											@endfor
											<!--
											<i class="bi bi-star-fill"></i>
											<i class="bi bi-star-fill"></i>
											<i class="bi bi-star-fill"></i>
											<i class="bi bi-star-half"></i>
											<i class="bi bi-star"></i>
											<span class="text-secondary"><b>3.6</b>(10)</span>-->
											<span class="text-secondary"><b>{{round($star,1)}}</b>({{$num}})</span>
										</div>
										<p class="card-text">
											@if(isset($product->price->first()->amount))
												{{$product->price->first()->amount}}
												{!!$product->price->first()->currency->html !!}
											@endif
										</p>
										<!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
									</div>
								</div>
								</a>
							{{--	
							</div>

						</div>
					</div>--}}
					@php
						$i++
					@endphp
				@endforeach
				@if($i!=0)
							@if($i%4!=0)
								@for($k=$i%4;$k<4;$k++)
									
											<div class="card " style="width: 18rem;">
											</div>
									
								@endfor
							@endif
							</div>
						</div>
					</div>
				@endif

			</div>
			<a class="carousel-control-prev" href="#carouseladv" role="button" data-slide="prev" style="">
				<span class="carousel-control-prev-icon" aria-hidden="true" style=""></span>
				<span class="sr-only" style="">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouseladv" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

	</div>
</div>
<div style="padding-bottom: 400px;">
</div>

@endsection