<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{{env('APP_NAME')}}</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
    },6*60*60*1000);  </script>
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

	<style type="text/css">
		#sidebar ul li.active > a, a[aria-expanded="true"] {
			background: #263238 !important;
		}
		ul ul a {
			background: #263238 !important;
		}
		#sidebar .sidebar-header {
    		/*background: white !important;
    		color:black !important;
    		*/
    		background: #263238 !important;
    	}
      .adminzindex{

      }
    </style>
    @yield('subincludecontent')


    <link rel="stylesheet" href="/style5.css">
    <!-- Font Awesome JS -->
    {{--
    	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>--}}
    </head>
    <body>
<!--
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
  --
  <nav class="navbar navbar-expand-lg navbar-light bg-light sidebar">-->

  	<div class="wrapper col-lg-12 mw-100 adminzindex" style="padding: 0px;">
  		<!-- Sidebar Holder -->

  		<nav id="sidebar"  style="float: left;background: #263238">
  			<div class="sidebar-header">
  				<h3>{{env('APP_NAME')}}</h3><h4>{{__('messages.partner')}}</h4>
  			</div>

  			<ul class="list-unstyled components">
  				<!--	                <p>Dummy Heading</p>-->
          <li>
          	<a href="{{route('partner.dashboard',app()->getLocale())}}">{{__('messages.dashboard')}}</a>
          </li>


    <!-- 
	ticket
    -->
    		@if(Auth::user()->permpartner())
	    		<li class="">
	    			<a href="#ticketSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">{{__('messages.tourorticket')}}</a>
	  				<ul class="collapse list-unstyled" id="ticketSubmenu">
		          <li>
		            <a href="{{route('partner.product',app()->getLocale())}}">{{__('messages.productManagement')}}</a>
		          </li>
		        </ul>
	        </li>
	      @endif
<!-- Bus 
	-->
				@if(Auth::user()->permPartnerBus() )
          <li class="">
  					<a href="#busSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">{{__('messages.bus')}}</a>
  					<ul class="collapse list-unstyled" id="busSubmenu">
		        	<li>        		
		        		<a href="{{route('partner.bus.index',app()->getLocale())}}">{{__('messages.')}}</a>        		
		        	</li>
		        	<li>
		        		<a href="{{route('partner.bus.buses',app()->getLocale())}}">{{__('messages.buses')}}</a>
		        	</li>
		        </ul>
		      </li>	
		    @endif

          <li>
          	<a class="" href="{{route('account',app()->getLocale())}}">{{__('messages.profilemanagemant')}}</a>
          </li>

{{--
  				<li class="">
  					<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">a</a>
  					<ul class="collapse list-unstyled" id="homeSubmenu">
  						<li>
  							<a href="#">Search</a>
  						</li>
  						<li>
  							<a href="#">Home 2</a>
  						</li>
  						<li>
  							<a href="#">Home 3</a>
  						</li>
  					</ul>
  				</li>          
  				<li>
  					<a href="#">About</a>
  					<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
  					<ul class="collapse list-unstyled" id="pageSubmenu">
  						<li>
  							<a href="#">Page 1</a>
  						</li>
  						<li>
  							<a href="#">Page 2</a>
  						</li>
  						<li>
  							<a href="#">Page 3</a>
  						</li>
  					</ul>
  				</li>
  				<li>
  					<a href="#">Portfolio</a>
  				</li>
  				<li>
  					<a href="#">Contact</a>
  				</li>
          --}}
  			</ul>

  			<ul class="list-unstyled CTAs">
  				<li>

  				</li>

  			</ul>
  		</nav>
      

  		<!-- Page Content Holder -->
  		<div id="content2" class="col-md-12 col-lg-10 mw-100 adminzindex" style="min-width: 70%;padding: 0px">

  			<nav class="navbar navbar-expand-lg navbar-light bg-light">
  				<div class="container-fluid">

  					<button type="button" id="sidebarCollapse" class="navbar-btn">
  						<span></span>
  						<span></span>
  						<span></span>
  					</button>
  					<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  						<i class="fas fa-align-justify">X</i>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
              </svg>
  					</button>
            

  					<div class="collapse navbar-collapse" id="navbarSupportedContent">
  						<ul class="nav navbar-nav ml-auto">

  							<li class="nav-item">
  								<a class="nav-link" href="{{route('index',app()->getLocale())}}">{{__('messages.travelmode')}}</a>
  							</li>

  							<li class="nav-item">
									<a class="nav-link citiesnavbar" href="{{ route('logout',app()->getLocale()) }}"
										onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
										{{ __('messages.Logout') }}
									</a>
								</li>
  						</ul>
  						<form id="logout-form" action="{{ route('logout',app()->getLocale()) }}" method="POST" class="d-none">
								@csrf
							</form>
  					</div>
  				</div>
  			</nav>
  			
  			<div id="content" class="adminzindex" style="">
          @php
              $path=explode('/', url()->full());
              //print_r($path);
              //3 lang
              //4 ->
           @endphp
  				<nav aria-label="breadcrumb">
            <!--
				  <ol class="breadcrumb">
				    <li class="breadcrumb-item"><a href="#">Home</a></li>
				    <li class="breadcrumb-item active" aria-current="page">Library</li>
				  </ol>
        -->
				</nav>
          
          @yield('subcontent')
            
          {{--
  				<h2>Collapsible Sidebar Using Bootstrap 4</h2>
  				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
  				--}}
          
          
  			</div>
  		</div>
  	</div>
  	{{--
  		<!-- jQuery CDN - Slim version (=without AJAX) -->
  		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  		<!-- Popper.JS -->
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  		<!-- Bootstrap JS -->
  		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  		--}}
  		<script type="text/javascript">
  			$(document).ready(function () {
  				$('#sidebarCollapse').on('click', function () {
  					$('#sidebar').toggleClass('active');
  					$(this).toggleClass('active');
  				});
  			});
  		</script>
      @yield('submodalconent')

</body>
</html>