@extends('view')
@section('includecontent')
<title>{{__('page.indextitle')}}</title>
<meta property="og:title" content="{{__('page.indextitle')}}" />
<meta property="og:description" content="{{__('page.indexdescription')}}" />
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
		margin-left: 0px!important;
		margin-right: 0px!important;
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
	.limitcardtext{
		max-height: 3rem;
		text-overflow: ellipsis;
		overflow: hidden;
	}
</style>
 

@endsection
@section('content')
<div class="col-lg-10" style="margin: auto;">
	<div class="" style="margin-bottom: 30px; height: 100px">
		<div class="float-left">
			<h2 class="font-weight-bold">{{__('messages.WhatDoYouSearch')}}</h2>
		</div>
		<!--
		<div class="float-right">
			<a class="btn btn-light border" href="{{route('region',app()->getLocale())}}">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-diamond-fill" viewBox="0 0 16 16">
					<path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L4.047 3.339 8 7.293l3.954-3.954L9.049.435zm3.61 3.611L8.708 8l3.954 3.954 2.904-2.905c.58-.58.58-1.519 0-2.098l-2.904-2.905zm-.706 8.614L8 8.708l-3.954 3.954 2.905 2.904c.58.58 1.519.58 2.098 0l2.905-2.904zm-8.614-.706L7.292 8 3.339 4.046.435 6.951c-.58.58-.58 1.519 0 2.098l2.904 2.905z"/>
				</svg>
				<span class="" style="font-size: 20px;">{{__('messages.wholeCity')}}</span>
			</a>
			<br><br>
		</div>-->
	</div>
	
	<div id="carouselExampleControls" class="carousel slide carouselmobile" data-ride="carousel" style="margin-top: 30px;">
		<div class="carousel-inner">
			@php $i=0; @endphp
			@foreach($data['subpage'] as $subpage)
				<div class="carousel-item w-100 {{$i==0 ? 'active':''}}">
					<!--<img class="d-block w-100" src="..." alt="First slide">-->
					@php $img=""; @endphp
					@if( isset($subpage->SubpageMainPhoto->first()->Photo ) && NULL!=( $subpage->SubpageMainPhoto->first()->Photo) )
										@php
											$photo=$subpage->SubpageMainPhoto->first()->Photo;
												$img=$photo->folder."/".$photo->name;
										@endphp
										
										@endif
					<div class="card-deck " >
											@php
							$SubPageRouteName="bus.subpage";
							$region="r";
							$country="r";

							if($subpage->BusCompany!=NULL){
								$SubPageRouteName="bus.subpage";
								$comp=$subpage->BusCompany;
								$c=$comp->country;
								$country=$c->name;
								$region=$c->region->name;
							}
							if($subpage->HotelCompany!=NULL){
								$SubPageRouteName="hotel.subpage";
								$comp=$subpage->HotelCompany;
								$c=$comp->country;
								$country=$c->name;
								$region=$c->region->name;
							}
							if($subpage->RestaurantCompany!=NULL){
								$SubPageRouteName="restaurant.subpage";
								$comp=$subpage->RestaurantCompany;
								$c=$comp->country;
								$country=$c->name;
								$region=$c->region->name;
							}
						@endphp
						<a href="{{route($SubPageRouteName,['locale'=>app()->getLocale(), 'region'=>$region , 'country'=>$country ,'subpage'=>$subpage->id ])}} ">
							<div class="card cardcustom" style="	
						background-image: linear-gradient(142deg,rgba(0,0,0,.7),hsla(0,0%,100%,0) 65%),url('{{$img}}');margin-right:0px;width: 98%

						">

								@php
								/*
									$citynameecho="";
									$cityname=json_decode($city->namearray,true);
									$loc=app()->getLocale();
									if(isset($cityname[$loc])){
										$citynameecho=$cityname[$loc];
									}else{
										$citynameecho=$city->name;
									}*/
							 	@endphp
							<!--
						<div class="card">							
							<img class="card-img-top" src="{{$img}}" alt="Card image cap" height="350px;border-radius: 5%;">
						-->
							<div class="card-img-overlay" style="background-image: linear-gradient(142deg,rgba(0,0,0,.7),hsla(0,0%,100%,0) 65%); color:white">
								<h5 class="card-title font-weight-bold">{{$subpage->title}}</h5>
								<p class="card-text">{{--Text--}}</p>
								<p class="card-text"><small class="text-muted2"></small></p>
							</div>
						</div>
						</a>

					</div>
					
				</div>
				@php $i++; @endphp
			@endforeach
			</div>
			<a class="carousel-control-prev " href="#carouselExampleControls" role="button" data-slide="prev" style="">
				<span class="carousel-control-prev-icon" aria-hidden="true" style=""></span>
				<span class="sr-only" style="">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
			
		<div id="carouselExampleControls2" class="carousel slide carouseldesktop" data-ride="carousel" style="">
			<div class="carousel-inner">
				@php
				$i=0;
				@endphp

				@foreach($data['subpage'] as $subpage)
					@if($i==0)
						<div class="carousel-item active">
							<div class="card-deck col-12 m-0 p-0">
					@elseif($i%4==0)
							</div>
						</div>
						<div class="carousel-item">
							<div class="card-deck col-12 m-0 p-0">
					@endif
									@php $img=""; @endphp
										@if( isset($subpage->SubpageMainPhoto->first()->Photo ) && NULL!=( $subpage->SubpageMainPhoto->first()->Photo) )
											@php
												//$photo=$subpage->photos()->where('notes','small')->first();
												$photo=$subpage->SubpageMainPhoto->first()->Photo;
												$img=$photo->folder."/".$photo->name;
											@endphp
										
										@endif
						<!--<img class="d-block w-100" src="..." alt="First slide">-->
						<div class="card cardcustom" style="	
						background-image: linear-gradient(142deg,rgba(0,0,0,.7),hsla(0,0%,100%,0) 65%),url('{{$img}}');
  height: 500px;
  background-position: center;
    background-repeat: no-repeat;
  background-size: cover;
						">
						@php
							$SubPageRouteName="bus.subpage";
							$region="r";
							$country="r";

							if($subpage->BusCompany!=NULL){
								$SubPageRouteName="bus.subpage";
								$comp=$subpage->BusCompany;
								$c=$comp->country;
								$country=$c->name;
								$region=$c->region->name;
							}
							if($subpage->HotelCompany!=NULL){
								$SubPageRouteName="hotel.subpage";
								$comp=$subpage->HotelCompany;
								$c=$comp->country;
								$country=$c->name;
								$region=$c->region->name;
							}
							if($subpage->RestaurantCompany!=NULL){
								$SubPageRouteName="restaurant.subpage";
								$comp=$subpage->RestaurantCompany;
								$c=$comp->country;
								$country=$c->name;
								$region=$c->region->name;
							}
						@endphp
							<a href="{{route($SubPageRouteName,['locale'=>app()->getLocale(), 'region'=>$region , 'country'=>$country ,'subpage'=>$subpage->id ])}}">
								@php
								/*
									$citynameecho="";
									$cityname=json_decode($city->namearray,true);
									$loc=app()->getLocale();
									if(isset($cityname[$loc])){
										$citynameecho=$cityname[$loc];
									}else{
										$citynameecho=$city->name;
									}*/
							 	@endphp
									<!--
										<img class="card-img-top " src="/image/download3.jpg" alt="Card image cap" height="350px;border-radius: 0%;">-->
										
										<!--
										<img class="card-img-top cardcustom" src="{{$img}}" alt="Card image cap" height="350px;" style="">-->
										
										<div class="card-img-overlay " style="color: white;
										 	">

											<h5 class="card-title font-weight-bold border-warning border-bottom" style="border-width: 2px!important;">{{$subpage->title}}</h5>

											<p class="card-text font-weight-bold"></p>
											<p class="card-text font-weight-bold"><small class="text-muted2" style="color:white"></small></p>
											<!--<p class="card-text font-weight-bold " style="padding-top: 200px"><button class="btn btn-light border">{{__('messages.tour')}}</button></p>
										-->
										</div>
									</a>
								</div>
								
								@php 
								$i++;
								@endphp
						@endforeach


						@if($i!=0)
							@if($i%4!=0)
								@for($k=$i%4;$k<4;$k++)
									
											<div class="card cardcustom" style="">
											</div>
									
								@endfor
							@endif
							</div>
						</div>
						@endif

					</div>
					
					<a class="carousel-control-prev col-lg-1" href="#carouselExampleControls2" role="button" data-slide="prev" style="padding: 0px;margin-bottom: 70px;">
						<span class="carousel-control-prev-icon" aria-hidden="true" style=""></span>
						<span class="sr-only" style="">Previous</span>
					</a>
					<a class="carousel-control-next col-lg-1" href="#carouselExampleControls2" role="button" data-slide="next" style="padding: 0px;">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>

		<!-- Advertising start -->
@if(false)
			<div id="carouseladvertising" class="carousel slide border" data-ride="carousel" style="padding-top: 60px">
					<div class="carousel-inner">
					@php $i=0; @endphp
					@if(isset($data['advertising']))
						@foreach($data['advertising'] as $ad_row)
							@php							
								$img=$ad_row->files()->first();
								if($img==NULL){
									continue;
								}

							@endphp
							
						
							
								<div class="carousel-item {{$i==0 ? 'active':''}}">
									<div class="card-deck col-12 p-0">
										<div class="card-deck col-12 p-0">							
											<div class="card pr-0 mr-0 border-0" style="">
												@if($ad_row->url !=NULL)
														<a href="{{$ad_row->url}}">
												@endif	
												<div class="float-left" style="
													background-image: url('{{$img->path}}{{$img->name}}');
													height: 300px;
													width: 100%;
													background-size: cover;
													background-repeat: no-repeat;
													background-position: center;
													">
												</div>
												@if($ad_row->url !=NULL)
													</a>
												@endif
												
												<!--
												<img class="card-img-top " src="{{$img->path}}{{$img->name}}" alt="Card image cap" height="250px"
												style="border-radius: 0%;">
											-->

												<!--
												<div class="card-img-overlay" style="background-image: linear-gradient(142deg,rgba(0,0,0,.7),hsla(0,0%,100%,0) 65%); color:white; border-radius: 0%;">
													<h5 class="card-title">A Card title</h5>
													<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
													<p class="card-text"><small class="text-muted2" style="color:white">Last updated 3 mins ago</small></p>
												</div>-->
											</div>

											<div class="card border-0" >			
												<div class="float-left">
													<h3>
														@if($ad_row->url !=NULL)
																<a href="{{$ad_row->url}}">
														@endif
														{!! nl2br(htmlspecialchars($ad_row->text,ENT_QUOTES) ) !!}
														@if($ad_row->url !=NULL)
													</a>
												@endif
														</h3>
												</div>								
											</div>
											
											
										</div>
										
									</div>
								</div>
								
							
							
							@php $i++; @endphp
						@endforeach
					@endif
				</div>
				<a class="carousel-control-prev" href="#carouseladvertising" role="button" data-slide="prev" style="">
					<span class="carousel-control-prev-icon bg-dark" aria-hidden="true" style=""></span>
					<span class="sr-only" style="">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouseladvertising" role="button" data-slide="next">
					<span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>


@endif


		<div id="productcarouselExampleControls" class="carousel slide carouselmobile" data-ride="carousel" style="margin-top: 30px;">
				<div class="carousel-inner">
				@php $i=0; @endphp
				@php
						$count=count($data['product']);
				@endphp
			@foreach($data['product'] as $prow)
				<div class="carousel-item w-100 {{$i==0 ? 'active':''}}">


					<!--<img class="d-block w-100" src="..." alt="First slide">-->

					@php
										$pphoto=$prow->photo->where('checkadmin',1)->first();
										$im="/img/default.png";
										if($pphoto!=NULL && $pphoto->checkadmin){
											$im=$pphoto->photo->folder."/".$pphoto->photo->name;
										}

										$product=$prow;

										$cityname=NULL;
										$cname="";
										if(isset($product->city) && isset($product->city->namearray)){
											$cityname=json_decode($product->city->namearray,true);
										}
										$loc=app()->getLocale();
										if(isset($cityname[$loc])){
											$cname=$cityname[$loc];									
										}elseif(isset($data['city'])){
											$cname=$data['city']->name;
										}									
										if($cname==""){
											$cname=__('messages.'.$product->country->name);
										}
									@endphp
					<!--{{--
					@php $img=""; @endphp
					@if(NULL!=( $city->photos()->where('notes','small')->first()) )
										@php
											$photo=$city->photos()->where('notes','small')->first();
											$img=$photo->folder."/".$photo->name;
										@endphp
										
										@endif
										--}}-->
					<div class="card-deck " >
						<a href="{{route('offers.product',['locale'=>app()->getLocale(),'slug'=>$product->title]) }}">
							<div class="card cardcustom" style="	
						background-image: linear-gradient(142deg,rgba(0,0,0,.7),hsla(0,0%,100%,0) 65%),url('{{$im}}');margin-right:0px;width: 98%

						">

							<!--{{--
								@php
									$citynameecho="";
									$cityname=json_decode($city->namearray,true);
									$loc=app()->getLocale();
									if(isset($cityname[$loc])){
										$citynameecho=$cityname[$loc];
									}else{
										$citynameecho=$city->name;
									}
							 	@endphp
						
							<div class="card-img-overlay" style="background-image: linear-gradient(142deg,rgba(0,0,0,.7),hsla(0,0%,100%,0) 65%); color:white">
								<h5 class="card-title font-weight-bold">{{$citynameecho}}</h5>
								<p class="card-text">{{--Text--}}</p>
								<p class="card-text"><small class="text-muted2"></small></p>
							</div>
							--}}-->
						</div>
							<div class="card-body">
										<span class="card-text">
											<small class="text-muted2">{{__('messages.'.$product->category->name)}}</small>
											<small class="text-muted2">
												{{$cname}}
											</small>
										</span>
										<h5 class="card-title linelimit limitcardtext" style="height: 200px;">{{$product->onelinesummary}}</h5>
										
										@php
											$feedback=$product->feedbackstat();					
											$star="?";
											$num="?";
											if(isset($feedback->avgstar)){
												$star=$feedback->avgstar;
												$num=$feedback->num;
											}
										@endphp

										<div class="{{$num!='?' ? 'text-primary':'text-secondary'}} " style="font-size: 12px;">
											@for($j=0;$j<=5;$j++)
												@if($j<$star)
													<i class="bi bi-star-fill"></i>
												@elseif($j>1 &&  ($j-0.5)<=($star) )
													<i class="bi bi-star-half"></i>
												@else
													<i class="bi bi-star fa-xs" style="font-size: 12px;"></i>
												@endif
											@endfor
											<!--
											<i class="bi bi-star-fill"></i>
											<i class="bi bi-star-fill"></i>
											<i class="bi bi-star-fill"></i>
											<i class="bi bi-star-half"></i>
											<i class="bi bi-star"></i>-->

											<span class="text-secondary"><b>{{round($star,1)}}</b>({{$num}})</span>
										</div>
										<p class="card-text">
											@if(isset($product->price->first()->amount))
												{{$product->price->first()->amount}}
												{!!$product->price->first()->currency->html !!}
											@endif
										</p>

										<a href="{{route('offers.product',['locale'=>app()->getLocale(),'slug'=>$product->title]) }}"  class="btn btn-primary">Go</a>
									</div>
						</a>

					</div>
					
				</div>
				@php $i++; @endphp
			@endforeach
			</div>
			<a class="carousel-control-prev " href="#productcarouselExampleControls" role="button" data-slide="prev" style="margin-bottom: 200px;">
				<span class="carousel-control-prev-icon" aria-hidden="true" style=""></span>
				<span class="sr-only" style="">Previous</span>
			</a>
			<a class="carousel-control-next" href="#productcarouselExampleControls" role="button" data-slide="next" style="margin-bottom:200px;">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
			



			<div id="carouseladv" class="carousel slide carouseldesktop col-12 pl-0 pr-0" data-ride="carousel" style="padding-top: 60px">
				<div class="carousel-inner">
<!--
					<ol class="carousel-indicators">
						@for($j=0;$j<8;$j++)
						<li data-target="#carouselExampleIndicators" data-slide-to="{{$j}}" class="{{$j==0 ? 'active':''}}"></li>
						@endfor

					</ol>
				-->
				@php
					$count=count($data['product']);
				@endphp
				@for($i=0;$i<$count;)
					@php
						$k=$i;
						$limit=$k+4;
						if($limit>$count){
							$limit=$count;
						}
					@endphp
					<div class="carousel-item {{$i==0 ? 'active':''}}">
						<div class="card-deck col-12 p-0 ml-0">
							<div class="card-deck col-12 ml-0 p-0">
								<!--<img class="d-block w-100" src="..." alt="First slide">-->
								@for(;$i<$limit;$i++)
															
									@php
										$pphoto=$data['product'][$i]->photo->where('checkadmin',1)->first();
										$im="/img/default.png";
										if($pphoto!=NULL && $pphoto->checkadmin){
											$im=$pphoto->photo->folder."/".$pphoto->photo->name;
										}

										$product=$data['product'][$i];

										$cityname=NULL;
										$cname="";
										if(isset($product->city) && isset($product->city->namearray)){
											$cityname=json_decode($product->city->namearray,true);
										}
										$loc=app()->getLocale();
										if(isset($cityname[$loc])){
											$cname=$cityname[$loc];									
										}elseif(isset($data['city'])){
											$cname=$data['city']->name;
										}									
										if($cname==""){
											$cname=__('messages.'.$product->country->name);
										}
									@endphp
								<div class="card col-3 p-0" style="width: 18rem;">
									<div style="height: 236px; 
										background-repeat: no-repeat;
										background-size: cover;
										background-image: url('{!!$im!!}'); 
										background-position: center;" >

										<!--
									<img class="card-img-top" src="{{$im}}" alt="Card image cap" style="max-height:236px; max-width: 236px;">-->
									</div>
									<div class="card-body">
										<span class="card-text">
											<small class="text-muted2">{{__('messages.'.$product->category->name)}}</small>
											<small class="text-muted2">
												{{$cname}}
											</small>
										</span>
										<h5 class="card-title linelimit limitcardtext" style="height: 200px;">{{$product->onelinesummary}}</h5>
										
										@php
											$feedback=$product->feedbackstat();					
											$star="?";
											$num="?";
											if(isset($feedback->avgstar)){
												$star=$feedback->avgstar;
												$num=$feedback->num;
											}
										@endphp

										<div class="{{$num!='?' ? 'text-primary':'text-secondary'}} " style="font-size: 12px;">
											@for($j=0;$j<=5;$j++)
												@if($j<$star)
													<i class="bi bi-star-fill"></i>
												@elseif($j>1 &&  ($j-0.5)<=($star) )
													<i class="bi bi-star-half"></i>
												@else
													<i class="bi bi-star fa-xs" style="font-size: 12px;"></i>
												@endif
											@endfor
											<!--
											<i class="bi bi-star-fill"></i>
											<i class="bi bi-star-fill"></i>
											<i class="bi bi-star-fill"></i>
											<i class="bi bi-star-half"></i>
											<i class="bi bi-star"></i>-->

											<span class="text-secondary"><b>{{round($star,1)}}</b>({{$num}})</span>
										</div>
										<p class="card-text">
											@if(isset($product->price->first()->amount))
												{{$product->price->first()->amount}}
												{!!$product->price->first()->currency->html !!}
											@endif
										</p>

										<a href="{{route('offers.product',['locale'=>app()->getLocale(),'slug'=>$product->title]) }}"  class="btn btn-primary">Go</a>
									</div>

								</div>
								@endfor
								
							</div>
						</div>
					</div>
				@endfor
			</div>
			<a class="carousel-control-prev" href="#carouseladv" role="button" data-slide="prev" style="margin-bottom: 200px;margin-top: 100px;">
				<span class="carousel-control-prev-icon" aria-hidden="true" style=""></span>
				<span class="sr-only" style="">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouseladv" role="button" data-slide="next" style="margin-bottom:200px;margin-top: 100px;">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
		
		<!-- 
			Popular


			Explore food toure, wine tour ......
		-->

		<div class=" pt-5">
			<h2>{{__('messages.indexPageText')}}</h2>
		</div>
	</div>



	@endsection