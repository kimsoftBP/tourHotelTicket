@extends('view')
@section('includecontent')

@endsection
@section('content')
<div class="col-lg-5">
	<form action="{{route('bus.find.message.post',app()->getLocale())}}" method="POST">
		<div class="col-lg-12">
			@csrf
			<input type="hidden" name="search" value="{{$data['BusFind']->id}}">
			
			<div>
				
			</div>

			
			<div class="form-group">
				<label>{{__('messages.title')}}</label>
				<input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}">
				@error('title')
					<div class="text-danger">{{$message}}</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="text">{{__('messages.text')}}</label>
				<textarea class="form-control @error('text') is-invalid @enderror" name="text" id="text"></textarea>
				@error('text')
					<div class="text-danger">{{$message}}</div>
				@enderror
			</div>
			<button class="btn btn-primary">{{__('messages.send')}}</button>
		</div>
	</form>
</div>

@endsection