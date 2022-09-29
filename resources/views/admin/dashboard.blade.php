@extends('admin.view')
@section('subincludecontent')

@endsection
@section('subcontent')

<div>
	@if($errors->any())
		<div class="alert text-danger">
			{{ implode('', $errors->all(':message')) }}
		</div>
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

	<button class="btn btn-info">+</button>
	<div>
		<form>
			<select name="language" class="form-control col-4 col-md-3 float-left">
				
			</select>
			<select name="country" class="form-control col-4 col-md-3 float-left">
				<option value=""></option>
				@foreach($data['country'] as $row)				
					@if($row->country!=NULL)
						
				
					<option value="{{$row->country->id}}" {{app('request')->input('country')==$row->country->id ? 'selected':'' }} >{{$row->country->name}}</option>
				
					@endif
				@endforeach
			</select>
			<select name="city" class="form-control col-4 col-md-3 float-left">
				<option value=""></option>
				@foreach($data['city'] as $row)
					@if($row->city!=NULL)
						<option value="{{$row->city->id}}" {{app('request')->input('city')==$row->city->id ? 'selected':''}}> {{$row->city->name}}</option>
					@endif
				@endforeach
			</select>
			<input class="btn btn-info" type="submit" name="submit" value="{{__('messages.search')}}">
		</form>
	</div>
	
	<table class="table table-hover">
		<tr>
			<th>{{__('messages.email')}}</th>
			<th>{{__('messages.country/city')}}</th>
			<th>{{__('messages.created')}}</th>
		</tr>
		@foreach($data['products'] as $product)
			<tr>
				<td>{{$product->user->email}}</td>
				<td>{{$product->country->name ?? ''}}/{{$product->city->name ?? ''}}</td>
				<td>{{$product->created_at}}</td>
			</tr>
		@endforeach
	</table>	
	@php
		$from=$data['page']-2;
		$to=$data['page']+2;
		if($from<=0){
			$from=1;
		}
		if($to>$data['pages']){
			$to=$data['pages'];
		}
	@endphp
	<nav aria-label="Page navigation example">
	  <ul class="pagination justify-content-center">
	    <li class="page-item {{$data['page']<=1 ? 'disabled':''}}"><a class="page-link" href="{{route('admin.dashboard',app()->getLocale())}}?page={{$data['page']-1}}&{{$data['url']}}">Previous</a></li>
	    @for($i=$from;$i<=$to;$i++)
	    	<li class="page-item {{$i==$data['page'] ? 'disabled':''}}"><a class="page-link" href="#">{{$i}}</a></li>	    
	    @endfor
	    <li class="page-item {{$data['page']>=$data['pages'] ? 'disabled':''}} "><a class="page-link" href="{{route('admin.dashboard',app()->getLocale())}}?page={{$data['page']+1}}&{{$data['url']}}">Next</a></li>
	  </ul>
	</nav>
</div>
@endsection