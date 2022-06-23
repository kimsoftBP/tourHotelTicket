@extends('view')
@section('includecontent')

@endsection
@section('content')
<div class="col-lg-10" style="margin: auto;">
	<div style="text-align: center;margin-top:20px;margin-bottom: 30px;">
		<h4>{{__('messages.changepassword')}}</h4>
	</div>
	<div class="card col-lg-6" style="margin: auto;padding-top: 40px;padding-bottom: 40px;">	
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
			
		<form method="POST" action="{{ route('account.changepassword',app()->getLocale()) }}">
                        @csrf
		<div class="form-group row">
			<label for="currentpassword" class="col-md-4 col-form-label text-md-right">
				{{__('messages.currentpassword')}}
			</label>
			<div class="col-md-6"> 
				<input id="currentpassword" type="password" name="currentpassword" class="form-control @error('currentpassword') is-invalid @enderror" required autofocus>
				@error('currentpassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			</div>
		</div>

        <div class="form-group row ">
            <label for="password" class="col-md-4 col-form-label text-md-right ">{{ __('messages.password') }}</label>

            <div class="col-md-6">
               	<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('messages.confirmpassword') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>
        <div style="margin: auto;text-align: center;">
        	<input class="btn btn-primary col-10" type="submit" name="submit" value="{{__('messages.change')}}">
        </div>
    	</form>
	</div>
</div>
@endsection