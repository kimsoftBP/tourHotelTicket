</!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">



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
		},6*60*60*1000);  
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
<body>
	@php
		$routename="index";
		if(NULL!=\Route::currentRouteName() && \Route::currentRouteName()!="main" && \Route::currentRouteName()!="cities" && \Route::currentRouteName()!="offers.product" ){
			$routename=\Route::currentRouteName();
		}

		$langs=explode(',',env('AVAILABLE_LOCAL'))
	@endphp

	<div class="col-xl-12" style="margin:auto;padding:0px">
	@include('cookieConsent::index')
	<div class="col-lg-12 " style="margin: auto;">
		<div style="padding-top: 00px;">
			@yield('content')
		</div>
	</div>



	<div class="col-lg-12 ">
	<!-- Footer -->
	{{--
	<footer class="page-footer font-small stylish-color-dark pt-4 border-top" style="margin-top: 20px;">

		<!-- Footer Links -->
		<div class="container text-center text-md-left">

			<!-- Grid row -->
			<div class="row">

				<!-- Grid column -->
				<div class="col-md-4 mx-auto">

					<!-- Content -->
					<h5 class="font-weight-bold text-uppercase mt-3 mb-4">Footer Content</h5>
					<p>Here you can use rows and columns to organize your footer content. Lorem ipsum dolor sit amet,
						consectetur
					adipisicing elit.</p>

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
					<h5 class="font-weight-bold text-uppercase mt-3 mb-4">{{__('messages.partner')}}</h5>

					<ul class="list-unstyled">
						<li>
							<a href="{{route('partnersignup',app()->getLocale())}}">{{__('messages.signup')}}</a>
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
		--}}
		<!-- Footer Links -->

		<hr>


		<!-- Copyright -->
		<div class="footer-copyright text-center py-3">© 2020 Copyright:
			<a href=""></a>
		</div>
		<!-- Copyright -->

	</footer>
	</div>
	<!-- Footer -->
</div>
</body>
</html>
