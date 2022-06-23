@extends('view')
@section('includecontent')

@endsection
@section('content')

<div class="col-lg-10 float-none" style="margin: auto;">
	<h4>{{__('messages.profilemanagemant')}}</h4>
	<div class="h-100" style="margin-top: 20px;">
		<div class="col-12 col-md-3 h-100" style="float:left;margin-right: 20px;">
			<div class="card col-12" style="/*width: 18rem;*/">
			  <div class="card-body col-12" style="text-align: center;">
			  	

			  	<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
				  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
				  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
				</svg>
				<br>
				<br>
			  	<h6 class="card-title">{{$user->name}}</h6>
			  	<!--
			    <h5 class="card-title">Card title</h5>
			    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
			    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
			    <a href="#" class="card-link">Card link</a>
			    <a href="#" class="card-link">Another link</a>-->
			  </div>
			</div>
			<div class="card" style="/*width: 18rem;*/">
			  <div class="card-body">
			  </div>
			</div>
			<div class="card" style="/*width: 18rem;*/">
			  <div class="card-body">
			  </div>
			</div>
		</div>
		<div class="h-100 col-lg-12 float-none" style="">		
			<div class="card " >
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

			  <div class="card-body">
			  		<div class="text-right " style="padding-bottom: 20px;">
						<a href="{{route('account.edit',app()->getLocale())}}" class="btn btn-light border">{{__('messages.edit')}}</a>
					</div>
	<!--{{-- can edit name  phonenumber password--}} -->
				<div style="text-align: center; padding-bottom: 40px;padding-top: 00px;">
				  	<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
					  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
					  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
					</svg>
				</div>
			  	<table class="table">
			  		<tr>
			  			<th>{{__('messages.name')}}</th>
			  			<td>{{$user->name}}</td>
			  		</tr>
			  		<tr>
			  			<th>{{__('messages.email')}}</th>
			  			<td>{{$user->email}}</td>
			  		</tr>
			  		<tr>
			  			<th>{{__('messages.contact')}}</th>
			  			<td>
			  				@if($user->phonenumber!="" && $user->phonenumber!=NULL)
			  					{{$user->phonenumber}}
			  				@else
			  					{{__('messages.No mobile phone information')}}
			  				@endif
			  			</td>		  			
			  		</tr>
			  		@if($user->permpartner())
				  		<tr>
				  			<th>{{__('messages.country')}}</th>
				  			<td>
				  				@if($user->country!=NULL)
				  					{{$user->country->name}}
				  				@endif
				  			</td>
				  		</tr>
				  		<tr>
				  			<th>{{__('messages.city')}}</th>
				  			<td>
				  				@if($user->city!=NULL)
				  					{{$user->city}}
				  				@endif
				  			</td>
				  		</tr>
				  	@endif
			  		<!--{{-- marketing receipt email , sms ,,,,, --}}-->


			  	</table>
			  </div>
			</div>
		</div>
	</div>
</div>
@endsection