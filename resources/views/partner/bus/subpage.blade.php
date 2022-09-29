@extends('partner.view')
@section('subincludecontent')



@endsection
@section('subcontent')
<div>
	@if($data['subpage']!=NULL && isset($data['subpage']->id))
		<a href="{{route('bus.subpage',['locale'=>app()->getLocale(),'region'=>$data['region']->name ,'country'=>$data['country']->name, 'subpage'=>$data['subpage']->id ])}}" class="btn">{{route('bus.subpage',['locale'=>app()->getLocale(),'region'=>$data['region']->name ,'country'=>$data['country']->name, 'subpage'=>$data['subpage']->id ])}}</a>
	@endif

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


	<form action="{{route('partner.bus.subpage.save',app()->getLocale())}}" method="POST"  enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="buscomp" value="{{$data['buscompany']->id}}">
		<input type="hidden" name="subpage" value="{{$data['subpage']->id??''}}">

		<div class="form-group">
		 	<label>{{__('messages.title')}}</label>
		 	<input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title',$data['subpage']->title??'')}}">
		 	@error('title')
		 		<div class="text-danger">{{$message}}</div>
		 	@enderror
		</div>
		<div class="form-group">
			<label>{{__('messages.text')}}</label>
			<textarea name="text" class="form-control @error('text') is-invalids @enderror">{{old('text',$data['subpage']->text??'')}}</textarea>
			@error('text')
				<div class="text-danger">{{$message}}</div>
			@enderror
		</div>

		<div class="form-group">
			<label>{{__('messages.text')}}</label>
			<textarea name="textArea2" class="form-control">{{old('textArea2',$data['subpage']->text_area2??'')}}</textarea>
		</div>
		<div class="form-group">
			<label></label>
			<input type="file" name="mainPhoto">
		</div>
		<div class="col-12 row">
			@if($data['subpage']!=NULL && isset($data['subpage']->SubpageMainPhoto))
				@foreach($data['subpage']->SubpageMainPhoto as $subpagephoto)
					@php
						$photo=$subpagephoto->Photo;
					@endphp
					<div class="col-3">
						<img src="/{{$photo->folder}}/{{$photo->name}}" class="w-75">
						<input type="checkbox" name="photoDelete[{{$photo->id}}]" value="1">
					</div>
				@endforeach			
			@endif
		</div>

		
		<div class="form-group">
			<label>{{__('messages.photos')}}</label>
			<input type="file" name="photos[]" class="" multiple>
			@error('photos.*')
				<div class="text-danger">{{$message}}</div>
			@enderror
		</div>
		<div class="col-12 row">
			@if($data['subpage']!=NULL && isset($data['subpage']->SubpageOtherPhoto))
				@foreach($data['subpage']->SubpageOtherPhoto as $subpagephoto)
					@php
						$photo=$subpagephoto->Photo;
					@endphp
					<div class="col-3">
						<img src="/{{$photo->folder}}/{{$photo->name}}" class="w-75">
						<input type="checkbox" name="photoDelete[{{$photo->id}}]" value="1">
					</div>
				@endforeach
			@endif
		</div>
		<div>
			<button class="btn btn-success">{{__('messages.save')}}</button>
		</div>
	</form>
</div>
@endsection