<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-site-verification" content="{{env('SEARCHCONSOLE','')}}" />


	<meta property="og:type" content="website" />
	<meta property="og:image" content="" />
	
	<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
	<meta property="og:locale:alternate" content="{{ env('AVAILABLE_LOCAL','EN')}}" />
<!--
	<title>{{env('APP_NAME')}}</title>
-->
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script type="text/javascript">
		setInterval(function() {   
			var csrfToken = $('[name="_token"]').val(); 
			$.ajax({
				url: '{{ url("refresh-csrf") }}',
				type: 'get'
			}).done(function (data) {
				csrfToken = data;                            
			}).fail(function () {
				alert('Error');
			});
		},6*60*100);  
	</script>
	<style type="text/css">
		.js-cookie-consent{
			position: fixed;
			bottom: 10px;
			text-align: center;
			padding:10px;
			width:100%;
			z-index:9999;
			background-color:#fffbdb;
			border-color:#fffacc;
			border:solid 1px;
		}
	</style>
	@yield('includecontent')
</head>
<body style="max-width: 2000px;margin:auto;">
	@php
		$routename="index";
		if(NULL!=\Route::currentRouteName() && \Route::currentRouteName()!="main" && \Route::currentRouteName()!="cities" && \Route::currentRouteName()!="offers.product" ){
			$routename=\Route::currentRouteName();
		}

		$langs=explode(',',env('AVAILABLE_LOCAL'))
	@endphp

	<div class="col-xl-12 " style="margin:auto;padding:0px">
	@include('cookieConsent::index')
	<div class="citybackground">
		<div class="citybackgroundgray">
			<div class="col-lg-10 " style="margin: auto;">
				<div style="">
					<nav class="navbar navbar-expand-lg navbar-light bg-light">
						<button class="navbar-toggler citiesnavbar" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<a class="navbar-brand citiesnavbar font-weight-bold" href="{{route('index',app()->getLocale())}}" style="color: #555273;">
							<span style="    font-size: xx-large;">{{env('APP_NAME')}}</span>
							<!--<img src="{{asset('img/logo/logo_transparent3.png')}}" style="max-height: 40px; max-width:220px">-->
						</a>

						<div class="collapse navbar-collapse" id="navbarTogglerDemo03">


							<ul class="navbar-nav mr-auto mt-2 rmt-lg-0">

								{{--
								<li>
									<form class="form-inline my-2 my-lg-0" action="{{route('offers',app()->getLocale())}}" method="get">
										<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="q">
										<button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{__('messages.search')}}</button>
										<!--<button>Bus search</button>-->
									</form>	
								</li>--}}
								<li class="h4 nav-item active" >
									<a class="nav-link citiesnavbar" href="{{route('bus.search',app()->getLocale())}}" style="color: #555273;">{{__('messages.bus')}} <span class="sr-only">(current)</span></a>
								</li>
								<li class="h4 nav-item active" >
										<a class="nav-link citiesnavbar" href="{{route('hotel.search', app()->getLocale())}}" style="color: #555273;">{{__('messages.Hotel')}} <span class="sr-only">(current)</span></a>
								</li>
								
									
									<li class="h4 nav-item active" >
										<a class="nav-link citiesnavbar" href="{{route('restaurant.search',app()->getLocale())}}" style="color: #555273;">{{__('messages.Restaurant')}} <span class="sr-only">(current)</span></a>
									</li>
								@if(env('APP_ENV')=='local')
								@endif
								<!--
								<li class="nav-item active">
									<a class="nav-link citiesnavbar" href="#">Home <span class="sr-only">(current)</span></a>
								</li>-->
							<!--
							<li class="nav-item">
								<a class="nav-link" href="#">Link</a>
							</li>
							<li class="nav-item">
								<a class="nav-link disabled" href="#">Disabled</a>
							</li>
						-->
					</ul>
					

						<!--2
						<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
						</ul>
			

							<ul class="nav justify-content-end2 mr-auto mt-2 mt-lg-0">
							-->
							<ul class="navbar-nav justify-content-end2 mr-auto mt-2 mt-lg-0">
								{{--
									<li class="nav-item">
										<a class="nav-link disabled" href="#">register as partner</a>
									</li>
									--}}

									
									<li class="nav-item dropdown">
										 <a class="nav-link dropdown-toggle citiesnavbar"  id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag-icon flag-icon-{{__('messages.flag-'.app()->getLocale())}}"></span> {{__('messages.'.app()->getLocale())}}</a>
										<div class="dropdown-menu">
											@foreach($langs as $lang)
											   <a class="dropdown-item" href="{{route($routename,$lang)}}"><span class="flag-icon flag-icon-{{__('messages.flag-'.$lang)}}"> </span> {{__('messages.'.$lang)}}</a>
											@endforeach    
										</div>
									</li>
									
									@guest()
									<li class="nav-item">
										<a class="nav-link citiesnavbar " href="{{route('login',app()->getLocale())}}">{{__('messages.login')}}</a>
									</li>
									<li class="nav-item">
										<a class="nav-link citiesnavbar" href="{{route('register',app()->getLocale())}}">{{__('messages.usersignup')}}</a>
									</li>
									<li class="nav-item">
										<a class="nav-link citiesnavbar" href="{{route('partnersignup',app()->getLocale())}}">{{__('messages.suppliersignup')}}</a>
									</li>
									@else
									@php
									$user = Auth::user();
									@endphp
									{{--
									<li class="nav-item">
										<a class="nav-link citiesnavbar" href="#">wish list</a>
									</li>
									<li class="nav-item">
										<a class="nav-link citiesnavbar" href="#">my trip</a>
									</li>
									<li class="nav-item">
										<a class="nav-link citiesnavbar" href="#">messages</a>
									</li>
									<li class="nav-item">
										<a class="nav-link citiesnavbar" href="#">notice</a>
									</li>
									--}}
									
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle citiesnavbar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="{{route('account',app()->getLocale())}}">{{__('messages.profilemanagemant')}}</a>

											@if(!$user->permpartner() && $user->permadmin())
											<a class="dropdown-item" href="{{route('user.orders',app()->getLocale())}}">
												{{__('messages.orders')}}</a>
											@endif

											@if($user->permpartner())
												<a class="dropdown-item" href="{{route('partner',app()->getLocale())}}">{{__('messages.partnerpage')}}</a>
											@endif

											@if($user->permadminmenu() )
												<a class="dropdown-item" href="{{route('admin',app()->getLocale())}}">{{__('messages.admin')}}</a>
											@endif
<!--
											<a class="dropdown-item" href="#">Something else here</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="#">Separated link</a>
										-->
										</div>
									</li>
								<!--
									profile dropdown 
									-profile management
									-point
									-coupon
									-invite
									-partner page
									-korean in partner pages
									-logout
								-->
								<li class="nav-item">
									<a class="nav-link citiesnavbar" href="{{ route('logout',app()->getLocale()) }}"
										onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
										{{ __('messages.Logout') }}
									</a>
								</li>
								@endguest
							</ul>
							<form id="logout-form" action="{{ route('logout',app()->getLocale()) }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</nav>
				</div>
				<div class="citiesnavbar" style="">
					<b>
					<!--
						{{$shareddata['guides'] ?? '?'}} {{__('messages.guides')}}
						{{$shareddata['tours'] ?? '?'}} {{__('messages.tours')}}
						{{$shareddata['destinations'] ?? '?'}} {{__('messages.destinations')}}
					-->
						{{$shareddata['bus']??'?'}} {{__('messages.bus')}}
					</b>
				</div>
				<div>
					{{--
					@for($i=0;$i<6;$i++)
						<button class="btn btn-light">City/category</button>
					@endfor
					--}}
					@if(isset($searchsuggest) )
						@foreach($searchsuggest as $row)
							@php
								$c=$row->country->name;
								if($row->city!=NULL){
									$c=$row->city->name;
								}
							@endphp
							<a href="{{route('offers',['locale'=>app()->getLocale(), 'q'=>$c , 'category'=>$row->category->name ])}}" class="btn btn-light">
								{{$c}}/
								{{$row->category->name}}
							</a>
						@endforeach
					@endif
				</div>
				<div><!--
					<a href="" class="btn btn-light">
						{{__('messages.airlineticket')}}
					</a>
					<a href="" class="btn btn-light">
						{{__('messages.rooms')}}
					</a>-->
				</div>
				<div style="padding-top: 30px;" class="">
					@yield('contentbgimg')
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-12 p-0 " style="margin: auto;">
		<div style="padding-top: 00px;" class="d-flex justify-content-center">
			@yield('content')
		</div>
	</div>



	<div class="col-lg-12 ">
	<!-- Footer -->
	<footer class="page-footer font-small stylish-color-dark pt-4 border-top" style="margin-top: 20px;">

		<!-- Footer Links -->
		<div class="container text-center text-md-left">

			<!-- Grid row -->
			<div class="row">

				<!-- Grid column -->
				<div class="col-md-4 mx-auto">

					<!-- Content -->
					<h5 class="font-weight-bold text-uppercase mt-3 mb-4">Footer Content</h5>
					<p class="mb-0">Nagy Ignac utca 16 Budapest, Hungary</p>
					<p class="mb-0"><a href="tel:070 8816 1213">070 - 8816 - 1213</a></p>
					<p class="mb-0"><a href="tel:+36 70 4135 251">+36 70 4135 251</a></p>
					<a href="mailto:tourplatform365@gmail.com">tourplatform365@gmail.com</a>

				</div>
				<!-- Grid column -->

				<hr class="clearfix w-100 d-md-none">

				<!-- Grid column -->
				<div class="col-md-2 mx-auto">

					<!-- Links -->
					<h5 class="font-weight-bold text-uppercase mt-3 mb-4">{{__('messages.introduce')}}</h5>

					<ul class="list-unstyled">
						<li>
							<a href="#!">{{__('messages.aboutus')}}</a>
						</li>
						<!--
						<li>
							<a href="#!">{{__('messages.hire')}}</a>
						</li>-->
						<li>
							<a href="#!">{{__('messages.announcement')}}</a>
						</li>
					</ul>

				</div>
				<!-- Grid column -->

				<hr class="clearfix w-100 d-md-none">

				<!-- Grid column -->
				<div class="col-md-2 mx-auto">

					<!-- Links -->
					<h5 class="font-weight-bold text-uppercase mt-3 mb-4">{{__('messages.supplier')}}</h5>

					<ul class="list-unstyled">
						<li>
							<a href="{{route('partnersignup',app()->getLocale())}}">{{__('messages.registration')}}</a>
						</li>
						<li>
							<a href="{{route('partner.product',app()->getLocale() )}}">{{__('messages.footerpartnerupload')}}</a>
						</li>
						<!--<li>
							<a href="#!">{{__('messages.register as a partner')}}</a>
						</li>-->
						<!--
						<li>
							<a href="#!">Link 2</a>
						</li>
						<li>
							<a href="#!">Link 3</a>
						</li>
						<li>
							<a href="#!">Link 4</a>
						</li>-->
					</ul>

				</div>
				<!-- Grid column -->

				<hr class="clearfix w-100 d-md-none">

				<!-- Grid column -->
				<div class="col-md-2 mx-auto">

					<!-- Links -->
					<h5 class="font-weight-bold text-uppercase mt-3 mb-4">{{__('messages.support')}}</h5>

					<ul class="list-unstyled">
						<li>
							<a href="#">{{__('messages.footerkakaotalkconnection')}}</a>
						</li>
						<li>
							<a href="#">{{__('messages.footerhowtousethesite')}}</a>
						</li>

						<!--
						<li>
							<a href="#!">Link 1</a>
						</li>
						<li>
							<a href="#!">Link 2</a>
						</li>
						<li>
							<a href="#!">Link 3</a>
						</li>
						<li>
							<a href="#!">Link 4</a>
						</li>-->
					</ul>

				</div>
				<!-- Grid column -->

			</div>
			<!-- Grid row -->

		</div>
		<!-- Footer Links -->

		<hr>

{{--
		<!-- Call to action -->
		<ul class="list-unstyled list-inline text-center py-2">
			<li class="list-inline-item">
				<h5 class="mb-1">Register for free</h5>
			</li>
			<li class="list-inline-item">
				<a href="#!" class="btn btn-danger btn-rounded">Sign up!</a>
			</li>
		</ul>
		<!-- Call to action -->
		

		<hr>

		<!-- Social buttons -->
		<ul class="list-unstyled list-inline text-center">
			<li class="list-inline-item">
				<a class="btn-floating btn-fb mx-1">
					<i class="fab fa-facebook-f"> </i>
				</a>
			</li>
			<li class="list-inline-item">
				<a class="btn-floating btn-tw mx-1">
					<i class="fab fa-twitter"> </i>
				</a>
			</li>
			<li class="list-inline-item">
				<a class="btn-floating btn-gplus mx-1">
					<i class="fab fa-google-plus-g"> </i>
				</a>
			</li>
			<li class="list-inline-item">
				<a class="btn-floating btn-li mx-1">
					<i class="fab fa-linkedin-in"> </i>
				</a>
			</li>
			<li class="list-inline-item">
				<a class="btn-floating btn-dribbble mx-1">
					<i class="fab fa-dribbble"> </i>
				</a>
			</li>
		</ul>
		<!-- Social buttons -->
--}}
		<!-- Copyright -->
		<div class="footer-copyright text-center py-3">© {{now()->year}} Copyright:
			<a href=""></a>
		</div>
		<!-- Copyright -->

	</footer>
	</div>
	<!-- Footer -->
</div>
</body>
</html>
