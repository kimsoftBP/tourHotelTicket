@extends('view')
@section('includecontent')

@endsection
@section('content')

<div>
	<form action="{{route('bus.customer.message.post',app()->getLocale())}}" method="POST">
		<div>
			@csrf
			<input type="hidden" name="buscomp" value="{{$data['company']->id}}">
			<input type="hidden" name="bustype" value="{{$data['BusType']->id}}">
			<input type="hidden" name="from" value="{{$data['from']}}">
			<input type="hidden" name="fromdate" value="{{$data['fromdate']}}">
			<input type="hidden" name="todate" value="{{$data['todate']}}">
			<input type="hidden" name="persons" value="{{$data['persons']}}">
			<div>
				
			</div>

			<!--
			<div class="form-group">
				<label for="email">{{__('messages.email')}}</label>
				<input type="eamil" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{old('email')}}">
				@error('email')
					<div class="text-danger">{{$message}}</div>
				@enderror
			</div>-->
			<div class="form-group">
				<label for="text">{{__('messages.text')}}</label>
				<textarea class="form-control @error('text') is-invalid @enderror" name="text" id="text">{{old('text')}}</textarea>
				@error('text')
					<div class="text-danger">{{$message}}</div>
				@enderror
			</div>
			<button>{{__('messages.send')}}</button>
		</div>
	</form>
</div>

@endsection