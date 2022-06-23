@extends('partner.view')
@section('includecontent')

@endsection
@section('subcontent')
<div>
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
@if($errors->any())
	<div class="alert text-danger">
		{{ implode('', $errors->all(':message')) }}
	</div>
@endif

	<button class="round btn btn-sm btn-success" data-toggle="modal" data-target="#newModal">{{__('messages.addNewVehicle')}}</button>
	<div>
		<table class="table table-hover">
			@if(is_array($data['buses']))
			 asdf
			@endif
			<tr>
				<th class="col-2"></th>
				<th>{{__('messages.brand')}}</th>
				<th>{{__('messages.name')}}</th>
				<th>{{__('messages.seat')}}</th>
				<th>{{__('messages.licensePlate')}}</th>
			</tr>
			@if($data['buses']!=NULL )
				@foreach($data['buses'] as $bus)
					@php
						$type=$bus->BusType;
					@endphp
					<tr>
						<td>
							<button class="btn btn-sm">{{__('messages.edit')}}</button>
							<button class="btn btn-sm btn-danger">{{__('messages.delete')}}</button>
						</td>
						<td>{{$type->brand}}</td>
						<td>{{$type->name}}</td>
						<td>{{$type->seat}}</td>
						<td>{{$bus->license_plate}}</td>
					</tr>
				@endforeach
			@endif
		</table>
	</div>
</div>
@endsection
@section('submodalconent')

<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  		<form action="{{route('partner.bus.buses.add',app()->getLocale() )}}" method="POST">
  			@csrf
  			<input type="hidden" name="company" value="{{$data['company']->id}}">

  			
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.addNewVehicle')}}</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <datalist id="brand">
		      	@foreach($data['brand'] as $brand)
		      		<option value="{{$brand->brand}}">{{$brand->brand}}</option>
		      	@endforeach
		      </datalist>
		      <div class="modal-body">
		        <div class="form-group">
		        	<label>{{__('messages.brand')}}</label>
		        	<input type="text" name="brand" class="form-control" list="brand" value="{{old('brand')}}">
		        	@error('brand')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>
		        <div class="form-group">
		        	<label>{{__('messages.model')}}</label>
		        	<input type="text" name="model" class="form-control" value="{{old('model')}}">
		        	@error('model')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>
		        <div class="form-group">
		        	<label>{{__('messages.year')}}</label>
		        	<select name="year" class="form-control">		        		
		        		@for($i=0;$i<10;$i++)
		        			<option value="{{$data['year']-$i}}" {{old('year')==($data['year']-$i )? 'selected':''}}>{{$data['year']-$i}}</option>
		        		@endfor
		        	</select>
		        	@error('year')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>
		        <div class="form-group">
		        	<label>{{__('messages.licensePlate')}}</label>
		        	<input type="text" name="licensePlate" class="form-control" value="{{old('licensePlate')}}">
		        	@error('licensePlate')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>
		        <div class="form-group">
		        	<label>{{__('messages.seat')}}</label>
		        	<input type="text" name="seat" class="form-control" value="{{old('seat')}}">
		        	@error('seat')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button class="btn btn-primary">Save changes</button>
		      </div>
		    </div>
		</form>
  </div>
</div>
@endsection