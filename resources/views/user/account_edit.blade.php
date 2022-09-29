@extends('view')
@section('includecontent')

@endsection
@section('content')
<div class="col-lg-10" style="margin: auto;">
	<h4>{{__('messages.profilemanagemant')}}</h4>
	<div style="margin-top: 20px;">
		<div class="col-md-3 col-12" style="float:left;margin-right: 20px;">
			<div class="card col-12" style="/*width: 18rem;*/">
			  <div class="card-body" style="text-align: center;">
			  	

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
		<div class="col-lg-12 float-none" style="">		
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
				<form method="POST" action="{{ route('account.edit',app()->getLocale()) }}">
                        @csrf
			<div class="card " >

			  <div class="card-body">		  		
			  	<div style="text-align: center; padding-bottom: 40px;padding-top: 20px;">
				  	<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
					  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
					  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
					</svg>
				</div>

	<!--{{-- can edit name  phonenumber password--}} -->
			  	<div class="form-group row">
			  		  <label for="name" class="col-md-4 col-form-label text-md-right">
			  			{{__('messages.name')}}</label>
			  			 <div class="col-md-6">
			  				<input type="text" name="name" value="{{old('name',$user->name)}}">
			  			</div>
			  	</div>
			  	@error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			  	<div class="form-group row">
			  		  <label for="name" class="col-md-4 col-form-label text-md-right">
			  			{{__('messages.email')}}</label>
			  			<div class="col-md-6"> 
			  			{{$user->email}}
			  		</div>
			  	</div><!--
			  	@error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror-->
			  	<div class="form-group row">
			  		<label for="name" class="col-md-4 col-form-label text-md-right">
			  			{{__('messages.phonenumber')}}
			  		</label>
			  			<div class="col-md-6">
			  				<input type="text" name="phonenumber" value="{{old('phonenumber',$user->phonenumber)}}">
			  			</div>
			  	</div>
			  	@error('phonenumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			  	<div class="form-group row">
			  		<label for="name" class="col-md-4 col-form-label text-md-right">
			  			{{__('messages.password')}}
			  		</label>
			  		<div class="col-md-6">
			  			<a href="{{route('account.changepassword',app()->getLocale())}}">{{__('messages.changepassword')}}</a>
			  		</div>
			  	</div>
			  	@if($user->permpartner())
			  		<div class="form-group row">
			  			<label class="col-md-4 col-form-label text-md-right">{{__('messages.country')}}</label>
			  			<div class="col-md-6">
			  				<select class="form-control" name="country">
			  					<option></option>
			  					@foreach($data['country'] as $country)
			  						<option value="{{$country->id}}" {{old('country',$user->countryid)==$country->id ? 'selected':''}} >{{$country->name}}</option>
			  					@endforeach
			  				</select>
			  			</div>
			  		</div>

			  		<div class="form-group row">
			  			<label class="col-md-4 col-form-label text-md-right">{{__('messages.city')}}</label>
			  			<div class="col-md-6">
			  				<input type="text" class="form-control" name="city" value="{{old('city',$user->city)}}">
			  			</div>
			  		</div>
			  	@endif
			  		<!--{{-- marketing receipt email , sms ,,,,, --}}-->
			  		
			  	
			  	<div style="text-align: center;">
				  	<a href="{{ url()->previous() }}" class="btn btn-light border col-lg-5"> {{__('messages.cancel')}}</a>
					<input class="btn btn-primary col-lg-5" type="submit" name="submit" value="{{__('messages.save')}}">
			  	</div>
			  </div>
			</div>
			</form>

		</div>
	</div>
</div>
@endsection