@extends('view')
@section('includecontent')

<title>{{__('page.offerstitle')}}</title>
<meta property="og:title" content="{{__('page.offerstitle')}}" />
<meta property="og:description" content="{{__('page.offersdescription')}}" />
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
	.linelimit {
		max-height: 3rem;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
	}
</style>
<script type="text/javascript">
	function sendform(){
		$( "#search" ).submit();
	}
	function sendform2(){
		$( "#search2" ).submit();
	}
</script>

<!-- multi range slider css start -->
<style type="text/css">


[slider] {
  position: relative;
  height: 14px;
  border-radius: 10px;
  text-align: left;
  margin: 45px 0 10px 0;
}

[slider] > div {
  position: absolute;
  left: 13px;
  right: 15px;
  height: 14px;
}

[slider] > div > [inverse-left] {
  position: absolute;
  left: 0;
  height: 14px;
  border-radius: 10px;
  background-color: #CCC;
  margin: 0 7px;
}

[slider] > div > [inverse-right] {
  position: absolute;
  right: 0;
  height: 14px;
  border-radius: 10px;
  background-color: #CCC;
  margin: 0 7px;
}

[slider] > div > [range] {
  position: absolute;
  left: 0;
  height: 14px;
  border-radius: 14px;
  background-color: #1ABC9C;
}

[slider] > div > [thumb] {
  position: absolute;
  top: -7px;
  z-index: 2;
  height: 28px;
  width: 28px;
  text-align: left;
  margin-left: -11px;
  cursor: pointer;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
  background-color: #FFF;
  border-radius: 50%;
  outline: none;
}

[slider] > input[type=range] {
  position: absolute;
  pointer-events: none;
  -webkit-appearance: none;
  z-index: 3;
  height: 14px;
  top: -2px;
  width: 100%;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: alpha(opacity=0);
  -moz-opacity: 0;
  -khtml-opacity: 0;
  opacity: 0;
}

div[slider] > input[type=range]::-ms-track {
  -webkit-appearance: none;
  background: transparent;
  color: transparent;
}

div[slider] > input[type=range]::-moz-range-track {
  -moz-appearance: none;
  background: transparent;
  color: transparent;
}

div[slider] > input[type=range]:focus::-webkit-slider-runnable-track {
  background: transparent;
  border: transparent;
}

div[slider] > input[type=range]:focus {
  outline: none;
}

div[slider] > input[type=range]::-ms-thumb {
  pointer-events: all;
  width: 28px;
  height: 28px;
  border-radius: 0px;
  border: 0 none;
  background: red;
}

div[slider] > input[type=range]::-moz-range-thumb {
  pointer-events: all;
  width: 28px;
  height: 28px;
  border-radius: 0px;
  border: 0 none;
  background: red;
}

div[slider] > input[type=range]::-webkit-slider-thumb {
  pointer-events: all;
  width: 28px;
  height: 28px;
  border-radius: 0px;
  border: 0 none;
  background: red;
  -webkit-appearance: none;
}

div[slider] > input[type=range]::-ms-fill-lower {
  background: transparent;
  border: 0 none;
}

div[slider] > input[type=range]::-ms-fill-upper {
  background: transparent;
  border: 0 none;
}

div[slider] > input[type=range]::-ms-tooltip {
  display: none;
}

[slider] > div > [sign] {
  opacity: 0;
  position: absolute;
  margin-left: -11px;
  top: -39px;
  z-index:3;
  background-color: #1ABC9C;
  color: #fff;
  min-width: 28px;
  height: 28px;
  border-radius: 28px;
  -webkit-border-radius: 28px;
  align-items: center;
  -webkit-justify-content: center;
  justify-content: center;
  text-align: center;
}

[slider] > div > [sign]:after {
  position: absolute;
  content: '';
  left: 0;
  border-radius: 16px;
  top: 19px;
  border-left: 14px solid transparent;
  border-right: 14px solid transparent;
  border-top-width: 16px;
  border-top-style: solid;
  border-top-color: #1ABC9C;
}

[slider] > div > [sign] > span {
  font-size: 12px;
  font-weight: 700;
  line-height: 28px;
}

[slider]:hover > div > [sign] {
  opacity: 1;
}
</style>
<!-- multi range slider css end -->

<!-- multi range slider css2 start -->
<style>
.multi-range, .multi-range * { box-sizing: border-box; padding: 0; margin: 0; }
.multi-range { 
    position: relative; width: 160px; height: 28px; margin: 16px;
    border: 1px solid #ddd; font-family: monospace;
}
.multi-range > hr { position: absolute; width: 100%; top: 50%; }
.multi-range > input[type=range] {
    width: calc(100% - 16px); 
    position: absolute; bottom: 6px; left: 0;
}
.multi-range > input[type=range]:last-of-type { margin-left: 16px; }
.multi-range > input[type=range]::-webkit-slider-thumb { transform: translateY(-18px); }
.multi-range > input[type=range]::-webkit-slider-runnable-track { -webkit-appearance: none; height: 0px; }
.multi-range > input[type=range]::-moz-range-thumb { transform: translateY(-18px); }
.multi-range > input[type=range]::-moz-range-track { -webkit-appearance: none; height: 0px; }
.multi-range > input[type=range]::-ms-thumb { transform: translateY(-18px); }
.multi-range > input[type=range]::-ms-track { -webkit-appearance: none; height: 0px; }
.multi-range::after { 
    content: attr(data-lbound) ' - ' attr(data-ubound); 
    position: absolute; top: 0; 
    left: 100%;
    white-space: nowrap;
    display: block; padding: 0px 4px; margin: -1px 2px;
    height: 26px; width: auto; border: 1px solid #ddd; 
    font-size: 13px; line-height: 26px;
}
</style>
<!-- multi range slider css2 end -->
<script type="text/javascript">
function test1(){
	
}
</script>
@endsection
@section('content')
<div class="col-lg-10 pl-0 pr-0" style="margin: auto;">
	<div class="" style="margin-bottom: 30px; ">
		<!--{{-- mobile search --}}-->
		<div class="d-block d-sm-none">
			
			<div class="" style="overflow-x: scroll;white-space: nowrap;">
				<div class="list-group flex-row" id="list-tab" role="tablist2">
					<!--<a class="p-1 list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-all" role="tab" aria-controls="profile">{{__('messages.all')}}</a>
				-->
					<a class="p-2 list-group-item list-group-item-action {{NULL==$data['querycategory'] ? 'active':''}} " href="{{route('offers',['locale'=>app()->getLocale() ] )}}?page4={{$data['page']}}&{{$data['urlwithoutcategory']}}" >
					{{__('messages.all')}}</a>

					@foreach($data['category'] as $category)	
			      		<a class="p-2 list-group-item list-group-item-action {{$category->name==$data['querycategory'] ? 'active':''}}" id="list-home-list" data-toggle="list" href="#list-{{$category->id}}" role="tab" aria-controls="home">{{__('messages.'.$category->name)}}</a>
			      	@endforeach			      
			    </div>
			</div>
			<div>
				<div class="tab-content pb-2" id="nav-tabContent">
					<div class="tab-pane fade" id="list-all" role="tabpanel" aria-labelledby="list-all-list"></div>
					@foreach($data['category'] as $category)		
						<div class="tab-pane fade {{$category->name==$data['querycategory'] ? 'show active':''}}" id="list-{{$category->id}}" role="tabpanel" aria-labelledby="list-{{$category->id}}-list" style="overflow-x: scroll;white-space: nowrap;">
						@foreach($category->subcategory as $subcategory)
							@if(count($subcategory->productsubcat )>0)

							@endif
								<a href="{{route('offers',['locale'=>app()->getLocale() ] )}}?page4={{$data['page']}}&{{$data['url']}}&category={{$category->name}}&subcat={{$subcategory->name}}" class="text-dark btn btn-light border">
														<span class="{{$subcategory->name==$data['querysubcategory'] ? 'font-weight-bold':''}}">{{__('messages.'.$subcategory->name)}}</span></a>
							<!--
								{{__('messages.'.$subcategory->name)}}
							-->
						@endforeach				
						</div>
					@endforeach
					<!--
			      <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">1...</div>-->
			      <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">2...</div>
			      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">3...</div>
			      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">4...</div>
			    </div>
			</div>
			<div class="" style="overflow-x: scroll;white-space: nowrap;">
<!--
				<button type="button" class="btn btn-light border" data-toggle="modal" data-target="#modalcategory">
					{{__('messages.category')}}
				</button>-->
				<button type="button" class="btn btn-light border" data-toggle="modal" data-target="#modalgrade">
				 {{__('messages.grade')}}
				</button>				
				<button type="button" class="btn btn-light border" data-toggle="modal" data-target="#modaltourfrom">
				{{__('messages.tourform')}}
				</button>
				<button type="button" class="btn btn-light border" data-toggle="modal" data-target="#modallanguage">
				{{__('messages.language')}}
				</button>
				<button type="button" class="btn btn-light border" data-toggle="modal" data-target="#modaltime">
					{{__('messages.time')}}
				</button>
				<button type="button" class="btn btn-light border" data-toggle="modal" data-target="#modalmeetingtime">
				{{__('messages.meetingtime')}}
				</button>
			</div>
		</div>
		<div class="col-12">
			
			<h3>
				<!--
				{{__('messages.Search Results for')}}
				-->
				{{app('request')->input('q')}}
			</h3>
			
		</div>
		<!--{{-- search bar --}}-->
		<div class="col-3 float-sm-left float-md-left float-lg-left p-2 d-none d-sm-block" style="2display: none;">
			<div class="border">		
				<form id="search">
					<input type="hidden" name="q" value="{{$data['q']}}">
					<div class="border-bottom pb-2 m-3">
						<nav id="sidebar">
							
				  			<ul class="list-unstyled components">
				  				<li>
				  					<a href="{{route('offers',['locale'=>app()->getLocale() ] )}}?page4={{$data['page']}}&{{$data['urlwithoutcategory']}}" class="text-dark">
				  						<span><img src="/img/ic_categoryall.svg" height="30px"></span>
										<span class="{{NULL==$data['querycategory'] ? 'font-weight-bold':''}}">{{__('messages.all')}}</span></a>
				  				</li>
				  				@foreach($data['category'] as $category)				
					  				<li class="">
					  					<a href="#sub{{$category->id}}" data-toggle="collapse" aria-expanded="{{$category->name==$data['querycategory'] ? 'true':'false'}}" class="dropdown-toggle text-dark">
											<span><img src="/img/{{$category->iconfilename}}" height="30px"></span>
											<span class="{{$category->name==$data['querycategory'] ? 'font-weight-bold':''}}">
												{{__('messages.'.$category->name)}}
											</span>								
										</a>
										<ul class="collapse list-unstyled pl-4 {{$category->name==$data['querycategory'] ? 'show':''}}" id="sub{{$category->id}}">
											<li>
												<a href="{{route('offers',['locale'=>app()->getLocale() ] )}}?page4={{$data['page']}}&{{$data['url']}}&category={{$category->name}}" class="text-dark">
													<span class="{{$category->name==$data['querycategory'] && NULL==$data['querysubcategory'] ? 'font-weight-bold':''}}">{{__('messages.all')}}
													</span></a>
											</li>
											@foreach($category->subcategory as $subcategory)
												@if(count($subcategory->productsubcat )>0)

												@endif
												<li>
													<a href="{{route('offers',['locale'=>app()->getLocale() ] )}}?page4={{$data['page']}}&{{$data['url']}}&category={{$category->name}}&subcat={{$subcategory->name}}" class="text-dark">
														<span class="{{$subcategory->name==$data['querysubcategory'] ? 'font-weight-bold':''}}">{{__('messages.'.$subcategory->name)}}</span></a>
												</li>
												
											@endforeach										
										</ul>
									</li>
								@endforeach
				  			</ul>
				  			
				  		</nav>


					</div>
					<!--
					<div class="border-bottom pb-2 m-3">
						<span>{{__('messages.category')}}</span>
						@foreach($data['category'] as $category)			
							{{--<button class="btn btn-light btn-sm  col-6 col-xs-6 col-sm-3 col-md-3 col-lg-3 text-left float-left" style="">
								--}}
								<br>
							<span><img src="/img/{{$category->iconfilename}}" height="30px"></span>
							<span>{{$category->name}}</span>
							{{--</button>--}}
						
						@endforeach
					</div>
					-->

					<div class="border-bottom pb-2 m-3">
						<span>{{__('messages.pricingrange')}}</span>
						

						@if(env('APP_NAME')=="Dev-tourguide")

			  				@php
			  					$slidermin=0;
			  					$sliderminposvalue=0;
			  					
			  					$slidermax=100000;
			  					$slidermaxposvalue=50000;
			  					//$slidermaxpos=70;
			  					$slidermaxpos=$slidermaxposvalue/($slidermax/100);
			  					$sliderminpos=$sliderminposvalue/($slidermax/100);
							@endphp
							<div slider id="slider-distance" class="">
							  <div>
							    <div inverse-left style="width:70%;"></div>
							    <div inverse-right style="width:70%;"></div>
							    <div range style="left:{{$sliderminpos}}%;right:{{100-$slidermaxpos}}%;"></div>
							    <span thumb style="left:{{$sliderminpos}}%;"></span>
							    <span thumb style="left:{{$slidermaxpos}}%;"></span>
							    <div sign style="left:{{$sliderminpos}}%;    opacity: 1;">
							      <span id="value" class="pl-1 pr-1">{{$sliderminposvalue}}</span><!-- 30 -->
							    </div>
							    <div sign style="left:{{$slidermaxpos}}%; opacity: 1">
							      <span id="value" class="pl-1 pr-1">{{$slidermaxposvalue}}</span><!-- 60 -->
							    </div>
							  </div>
							  <input type="range"  tabindex="0" value="{{$sliderminpos}}" max="100" min="0" step="1" oninput="
							  this.value=Math.min(this.value,this.parentNode.childNodes[5].value-1);
							  var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
							  var children = this.parentNode.childNodes[1].childNodes;
							  children[1].style.width=value+'%';
							  children[5].style.left=value+'%';
							  children[7].style.left=value+'%';
							  children[11].style.left=value+'%';
							  children[11].childNodes[1].innerHTML=this.value*{{$slidermax/100}};" />
							  <input type="range" tabindex="0" value="{{$slidermaxpos}}" max="100" min="0" step="1" oninput="
							  this.value=Math.max(this.value,this.parentNode.childNodes[3].value-(-1));
							  var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
							  var children = this.parentNode.childNodes[1].childNodes;
							  children[3].style.width=(100-value)+'%';
							  children[5].style.right=(100-value)+'%';
							  children[9].style.left=value+'%';
							  children[13].style.left=value+'%';
							  children[13].childNodes[1].innerHTML=this.value*{{$slidermax/100}};" />
							</div>
						@endif
					

					</div>

					<div class="border-bottom pb-2 m-3 ">
						<h5>{{__('messages.grade')}}</h5>
						<div class="form-check">
							<input id="gradeall" type="radio" name="grade" value="all" class="form-check-input" onchange="sendform()" {{app('request')->input('grade','all')=="all" ?'checked':''}}>
							<label for="gradeall" class="form-check-label">{{__('messages.all')}}</label>
						</div>
						<div class="form-check">
							<input id="grade4" type="radio" name="grade" value="4" class="form-check-input" onchange="sendform()" {{app('request')->input('grade','all')=="4" ?'checked':''}} >
							<label for="grade4" class="form-check-label">{{__('messages.grade4')}}</label>			
						</div>
						<div class="form-check">
							<input id="grade5" type="radio" name="grade" value="5" class="form-check-input" onchange="sendform()" {{app('request')->input('grade','all')==5 ?'checked':''}}  >
							<label for="grade5" class="form-check-label">{{__('messages.grade5')}}</label>
						</div>					
					</div>
		
	<!--
					<div class=" m-3">
						<span>{{__('messages.destination')}}</span>
						{{-- sights --}}
					</div>
					-->
					<div class="border-bottom pb-2 m-3">
						<h5>{{__('messages.tourform')}}</h5>				
						<div class="form-check">
							<input id="tsall" type="radio" name="toursize" value="all" class="form-check-input" onchange="sendform()" {{app('request')->input('toursize','all')=="all" ?'checked':''}}>
							<label for="tsall" class="form-check-label">{{__('messages.all')}}</label>
						</div>
						@foreach($data['toursize'] as $toursize)
						<div class="form-check">
							<input id="ts{{$toursize->id}}" type="radio" name="toursize" value="{{$toursize->id}}" id="" class="form-check-input" onchange="sendform()" {{app('request')->input('toursize')==$toursize->id ?'checked':''}}>
							<label for="ts{{$toursize->id}}" class="form-check-label">{{__('messages.'.$toursize->name)}}</label>
						</div>
						@endforeach
					</div>

					<div class="border-bottom pb-2 m-3">{{-- language --}}
						<label>{{__('messages.language')}}</label>
						<select class="form-control  @error('language') is-invalid @enderror" {{--multiple aria-label="multiple select language" size="4"--}} name="language" onchange="sendform()">	
							<option value=""></option>
							@foreach($data['language'] as $language)
								<!--{{--<option value="{{$language->id}}"
									{{(is_array(old('language')) && in_array($language->id,old('language')) ) ? 'selected':''}}
									>
									--}}-->									
								<option value="{{$language->id}}"
									{{old('language',$data['qlanguage'])==$language->id  ? 'selected':''}}
									>								
									{{__('messages.'.$language->name)}}							
								</option>
									
							@endforeach
						</select>
						@error('language')
		                    <span class="invalid-feedback" role="alert" style="display: block;">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                @enderror
					</div>
					<div class="border-bottom pb-2 m-3">
						<h5>{{__('messages.time')}}</h5>
						<div class="form-check">
							<input id="tall" type="radio" name="time" value="all" class="form-check-input" onchange="sendform()" {{app('request')->input('time','all')=="all" ?'checked':''}}>
							<label for="tall" class="form-check-label">{{__('messages.all')}}</label>					
						</div>
						<div class="form-check">
							<input id="t1" type="radio" name="time" value="0to2" class="form-check-input" onchange="sendform()" {{app('request')->input('time')=="0to2" ?'checked':''}}>
							<label for="t1" class="form-check-label">{{__('messages.within2')}}</label>
						</div>
						<div class="form-check">
							<input id="t2" type="radio" name="time" value="2to4" class="form-check-input" onchange="sendform()" {{app('request')->input('time')=="2to4" ?'checked':''}}>
							<label for="t2" class="form-check-label">{{__('messages.2to4')}}</label>
						</div>
						<div class="form-check">
							<input id="t3" type="radio" name="time" value="4to6" class="form-check-input" onchange="sendform()" {{app('request')->input('time')=="4to6" ?'checked':''}}>
							<label for="t3" class="form-check-label">{{__('messages.4to6')}}</label>
						</div>
						<div class="form-check">
							<input id="t4" type="radio" name="time" value="6to" class="form-check-input" onchange="sendform()" {{app('request')->input('time')=="6to" ?'checked':''}}>
							<label for="t4" class="form-check-label">{{__('messages.morethan6')}}</label>
						</div>
					</div>
					<div class=" m-3" >
						<h5>{{__('messages.meetingtime')}}</h5>
						<div class="form-check">
							<input id="mtall" type="radio" name="meetingtime" value="all" class="form-check-input" onchange="sendform()" {{app('request')->input('meetingtime','all')=="all" ?'checked':''}}>
							<label for="mtall" class="form-check-label">{{__('messages.all')}}</label>
						</div>
						<div class="form-check">
							<input id="mt1" type="radio" name="meetingtime" value="before 12" class="form-check-input" onchange="sendform()" {{app('request')->input('meetingtime')=="before 12" ?'checked':''}}>
							<label for="mt1" class="form-check-label">{{__('messages.before12')}}</label>
						</div>
						<div class="form-check">
							<input id="mt2" type="radio" name="meetingtime" value="afternoon" class="form-check-input" onchange="sendform()" {{app('request')->input('meetingtime')=="afternoon" ?'checked':''}}>
							<label for="mt2" class="form-check-label">{{__('messages.afternoon')}}</label>
						</div>
						<div class="form-check">
							<input id="mt3" type="radio" name="meetingtime" value="evening" class="form-check-input" onchange="sendform()" {{app('request')->input('meetingtime')=="evening" ?'checked':''}}>
							<label for="mt3" class="form-check-label">{{__('messages.evening')}}</label>
						</div>			
					</div>
				</form>
			</div>
		</div>
		<!--{{-- search list --}}-->
		<div class="col-12 col-sm-9 col-md-9 col-lg-9 float-sm-left float-md-left float-lg-left p-0">
			<div class="col-12 justify-content-center p-0 mx-auto">
				@php $i=0; $cname=""; @endphp
				@foreach($data['products'] as $product)
					@php
						if($product->title==NULL ){
							continue;
						}
					@endphp
								
								<!--<img class="d-block w-100" src="..." alt="First slide">-->
						<div class="card col-6 col-sm-4 col-md-4 col-lg-4 p-0 mb-2 2m-1 mt-2 float-left border-0" style="width: 18rem;height: 340px;/*width: 30%;*/">
							<div class="m-1 border rounded">
							<a href="{{route('offers.product',['locale'=>app()->getLocale(),'slug'=>$product->title]) }}" class="text-dark">
								@php									
									$pphoto=$product->photo->where('checkadmin',1)->first();
									$im="/img/default.png";
									if($pphoto!=NULL && $pphoto->checkadmin){
										$im=$pphoto->photo->folder."/".$pphoto->photo->name;
									}
									//$product->city
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
								@if($im!="")
								<div class="2h-50" style="height: 170px;">
									<img class="card-img-top" src="{{$im}}" alt="Card image cap" style="max-height: 170px ">
								</div>
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
										
								//		print_r( $product->avgfeedback() );
									@endphp
									<div class="{{$num!='?' ? 'text-primary':'text-secondary'}} " style="font-size: 12px;">
										@for($i=0;$i<=5;$i++)
											@if($i<$star)
												<i class="bi bi-star-fill"></i>
											@elseif($i>1 &&  ($i-0.5)<=($star) )
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
									<!--<a href="#" class="btn btn-primary">Go somewhere</a>-->
								</div>
							</a>					
						</div>
						</div>
								
					@php
						$i++
					@endphp
				@endforeach
				<div class="pb-4" style="clear: both;"></div>






















				<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  	@php
				  		$showpages=2;

				    	$i=$data['page']-$showpages;
				    	if($i<1){$i=1;}
				    	$to=$data['page']+$showpages;
				    	if($to>$data['pages']){$to=$data['pages'];}
				    @endphp
				    <li class="page-item {{$data['page']>1 ? '':'disabled'}}"><a class="page-link" href="{{route('offers',['locale'=>app()->getLocale() ] )}}?page={{$data['page']-1}}&{{$data['url']}}">Previous</a></li>				    
				    @for(;$i<=$to;$i++)
				    	<li class="page-item {{$i==$data['page']? 'disabled':''}}" ><a class="page-link" href="{{route('offers',['locale'=>app()->getLocale() ] )}}?page={{$i}}&{{$data['url']}}">{{$i}}</a></li>
				    @endfor
				    <li class="page-item {{$data['page']<$data['pages'] ? '':'disabled'}}"><a class="page-link" href="{{route('offers',['locale'=>app()->getLocale() ] )}}?page={{$data['page']+1}}&{{$data['url']}}">Next</a></li>
				  </ul>
				</nav>
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>


<form id="search2">

<!-- Modal -->
<div class="modal fade" id="modalgrade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">    
      <div class="modal-body">
        <div class="border-bottom pb-2 m-3 ">
			<h5>{{__('messages.grade')}}</h5>
			<div class="form-check">
				<input id="gradeall" type="radio" name="grade" value="all" class="form-check-input" onchange="sendform2()" {{app('request')->input('grade','all')=="all" ?'checked':''}}>
				<label for="gradeall" class="form-check-label">{{__('messages.all')}}</label>
			</div>
			<div class="form-check">
				<input id="grade4" type="radio" name="grade" value="4" class="form-check-input" onchange="sendform2()" {{app('request')->input('grade','all')=="4" ?'checked':''}} >
				<label for="grade4" class="form-check-label">{{__('messages.grade4')}}</label>			
			</div>
			<div class="form-check">
				<input id="grade5" type="radio" name="grade" value="5" class="form-check-input" onchange="sendform2()" {{app('request')->input('grade','all')==5 ?'checked':''}}  >
				<label for="grade5" class="form-check-label">{{__('messages.grade5')}}</label>
			</div>					
		</div>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modaltourfrom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">    
      <div class="modal-body">
			<div class="border-bottom pb-2 m-3">
				<h5>{{__('messages.tourform')}}</h5>				
				<div class="form-check">
					<input id="tsall" type="radio" name="toursize" value="all" class="form-check-input" onchange="sendform()" {{app('request')->input('toursize','all')=="all" ?'checked':''}}>
					<label for="tsall" class="form-check-label">{{__('messages.all')}}</label>
				</div>
				@foreach($data['toursize'] as $toursize)
				<div class="form-check">
					<input id="ts{{$toursize->id}}" type="radio" name="toursize" value="{{$toursize->id}}" id="" class="form-check-input" onchange="sendform()" {{app('request')->input('toursize')==$toursize->id ?'checked':''}}>
					<label for="ts{{$toursize->id}}" class="form-check-label">{{__('messages.'.$toursize->name)}}</label>
				</div>
				@endforeach
			</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modallanguage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">    
      <div class="modal-body">
			<div class="border-bottom pb-2 m-3">{{-- language --}}
				<label>{{__('messages.language')}}</label>
				<select class="form-control  @error('language') is-invalid @enderror" {{--multiple aria-label="multiple select language" size="4"--}} name="language" onchange="sendform()">	
					<option value=""></option>
					@foreach($data['language'] as $language)
						<!--{{--<option value="{{$language->id}}"
							{{(is_array(old('language')) && in_array($language->id,old('language')) ) ? 'selected':''}}
							>
							--}}-->									
						<option value="{{$language->id}}"
							{{old('language',$data['qlanguage'])==$language->id  ? 'selected':''}}
							>								
							{{__('messages.'.$language->name)}}							
						</option>
							
					@endforeach
				</select>
				@error('language')
                    <span class="invalid-feedback" role="alert" style="display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modaltime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">    
      <div class="modal-body">
			<div class="border-bottom pb-2 m-3">
				<h5>{{__('messages.time')}}</h5>
				<div class="form-check">
					<input id="tall" type="radio" name="time" value="all" class="form-check-input" onchange="sendform()" {{app('request')->input('time','all')=="all" ?'checked':''}}>
					<label for="tall" class="form-check-label">{{__('messages.all')}}</label>					
				</div>
				<div class="form-check">
					<input id="t1" type="radio" name="time" value="0to2" class="form-check-input" onchange="sendform()" {{app('request')->input('time')=="0to2" ?'checked':''}}>
					<label for="t1" class="form-check-label">{{__('messages.within2')}}</label>
				</div>
				<div class="form-check">
					<input id="t2" type="radio" name="time" value="2to4" class="form-check-input" onchange="sendform()" {{app('request')->input('time')=="2to4" ?'checked':''}}>
					<label for="t2" class="form-check-label">{{__('messages.2to4')}}</label>
				</div>
				<div class="form-check">
					<input id="t3" type="radio" name="time" value="4to6" class="form-check-input" onchange="sendform()" {{app('request')->input('time')=="4to6" ?'checked':''}}>
					<label for="t3" class="form-check-label">{{__('messages.4to6')}}</label>
				</div>
				<div class="form-check">
					<input id="t4" type="radio" name="time" value="6to" class="form-check-input" onchange="sendform()" {{app('request')->input('time')=="6to" ?'checked':''}}>
					<label for="t4" class="form-check-label">{{__('messages.morethan6')}}</label>
				</div>
			</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalmeetingtime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">    
      <div class="modal-body">
			<div class=" m-3" >
				<h5>{{__('messages.meetingtime')}}</h5>
				<div class="form-check">
					<input id="mtall" type="radio" name="meetingtime" value="all" class="form-check-input" onchange="sendform()" {{app('request')->input('meetingtime','all')=="all" ?'checked':''}}>
					<label for="mtall" class="form-check-label">{{__('messages.all')}}</label>
				</div>
				<div class="form-check">
					<input id="mt1" type="radio" name="meetingtime" value="before 12" class="form-check-input" onchange="sendform()" {{app('request')->input('meetingtime')=="before 12" ?'checked':''}}>
					<label for="mt1" class="form-check-label">{{__('messages.before12')}}</label>
				</div>
				<div class="form-check">
					<input id="mt2" type="radio" name="meetingtime" value="afternoon" class="form-check-input" onchange="sendform()" {{app('request')->input('meetingtime')=="afternoon" ?'checked':''}}>
					<label for="mt2" class="form-check-label">{{__('messages.afternoon')}}</label>
				</div>
				<div class="form-check">
					<input id="mt3" type="radio" name="meetingtime" value="evening" class="form-check-input" onchange="sendform()" {{app('request')->input('meetingtime')=="evening" ?'checked':''}}>
					<label for="mt3" class="form-check-label">{{__('messages.evening')}}</label>
				</div>			
			</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<!--
<div class="modal fade" id="modalgrade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">    
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>
-->


</form>
@endsection