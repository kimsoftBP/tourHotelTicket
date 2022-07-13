@extends('partner.view')
@section('subincludecontent')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
	function setdelete(value){
		$("#busvalue").val(value);
	//	$("#deleteModal").modal('show');
	}


	function editBus(result) {
   		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		 $.ajax({
		   type:'post',
		   url:'{{route('partner.bus.buses.edit',app()->getLocale())}}',
		   data:{_token: CSRF_TOKEN,'bus':result
	       			},
		 //  data:'_token = <?php echo csrf_token() ?>',
		   success:function(data) {
		   	//	$("#editModal").modal('show');
		   		$("#editModalBody").html(data.edithtml);
		      	//$("#country2").html(data.msg);
		   }
		});
	}
	function showcalendar(id){
			console.log('show');
			$("#calendar"+id).toggle();
			loadcalendar(id);
	}
	
	function loadcalendar(id,year,month) {
		console.log('load');
   		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		 $.ajax({
		   type:'post',
		   url:'{{route('partner.ajax.bus.available.calendar',app()->getLocale() )}}',
		   data:{_token: CSRF_TOKEN, 'id':id,'year':year,'month':month
	       			},
		 //  data:'_token = <?php echo csrf_token() ?>',
		   success:function(data) {
		      $("#dataCalendar"+id).html(data.html);
		   }
		});
	}
	function editCalendarIntervallum(id){
		console.log('edit intervall');

		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		 $.ajax({
		   type:'post',
		   url:'{{route('partner.bus.available.loadedit',app()->getLocale() )}}',
		   data:{_token: CSRF_TOKEN, 'id':id,
	       			},
		 //  data:'_token = <?php echo csrf_token() ?>',
		   success:function(data) {
		   	console.log(data.html);
		      $("#editCalendarIntervallumModalBody").html(data.html);
		   }
		});
	}
	function setNewBAI(id){
		$("#newBusAvInt").val(id);
	}
</script>


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

	<button class="round btn btn-sm btn-success" data-toggle="modal" data-target="#newModal" {{$data['company']==NULL?'disabled':''}}>{{__('messages.addNewVehicle')}}</button >
	<div>
		<table class="table table-hover">
			@if(is_array($data['buses']))
			 asdf
			@endif
			<tr>
				<th class="col-3"></th>
				<th>{{__('messages.brand')}}</th>
				<th>{{__('messages.name')}}</th>
				<th>{{__('messages.YearOfManufacture')}}</th>
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
							<button class="btn btn-sm" onclick="editBus({{$bus->id}})" data-toggle="modal" data-target="#editModal">{{__('messages.edit')}}</button>
							<button class="btn btn-sm btn-danger" onclick="setdelete({{$bus->id}})" data-toggle="modal" data-target="#deleteModal">{{__('messages.delete')}}</button>
							<button onclick="showcalendar('{{$bus->id}}')" class="btn btn-sm">{{__('messages.calendar')}}</button>
						</td>
						<td>{{$type->brand}}</td>
						<td>{{$type->name}}</td>
						<td>{{$bus->year}}</td>
						<td>{{$bus->passenger_seats}}</td>
						<td>{{$bus->license_plate}}</td>
					</tr>
					<tr style="display: none;" id="calendar{{$bus->id}}">
						<td colspan="5" id="dataCalendar{{$bus->id}}">
							
						</td>
					</tr>
				@endforeach
			@endif
		</table>
	</div>
</div>
@endsection
@section('submodalconent')
<div class="modal fade" id="editCalendarIntervallumModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form method="POST" action="{{route('partner.bus.available.edit',app()->getLocale())}}">
    		@csrf
		    <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.edit')}}</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    <div class="modal-body" id="editCalendarIntervallumModalBody">

		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
		        <button class="btn btn-success">{{__('messages.save')}}</button>
		    </div>
		</form>
	</div>
  </div>
</div>

<div class="modal fade" id="newCalendarIntervallumModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form method="POST" action="{{route('partner.bus.available.new',app()->getLocale())}}">
    		@csrf
    		<input type="hidden" name="bus" value="" id="newBusAvInt">
		    <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.new')}}</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    <div class="modal-body" id="newCalendarIntervallModalBody">
		    	<div class="form-group row">
			    	<label class="col-form-label col-12">{{__('messages.from')}}</label>
			    	<div class="col-5 row">
			    		<input type="date" name="fromDate" class="col-11 form-control @error('fromDate') is-invalid @enderror" required>
			    		<sup class="text-danger"><i class="bi bi-star-fill"></i></sup>
			    		@error('fromDate')
			    			<div class="text-danger">{{$message}}</div>
			    		@enderror
			    	</div>
			    	<div class="col-5">
			    		<input type="time" name="fromTime" class="form-control @error('fromTime') is-invalid @enderror">
			    		@error('fromTime')
			    			<div class="text-danger">{{$message}}</div>
			    		@enderror
			    	</div>
			    	<label class="col-form-label col-12">{{__('messages.to')}}</label>

			    	<div class="col-5 row">
			    		<input type="date" name="toDate" class="col-11 form-control @error('toDate') is-invalid @enderror" required>
			    		<sup class="text-danger"><i class="bi bi-star-fill"></i></sup>
			    		@error('toDate')
			    			<div class="text-danger">{{$message}}</div>
			    		@enderror
			    	</div>
			    	<div class="col-5">
			    		<input type="time" name="toTime" class="form-control @error('toTime') is-invalid @enderror">
			    		@error('toTime')
			    			<div class="text-danger">{{$message}}</div>
			    		@enderror
			    	</div>

			    	<div class="col-8 mt-2 row">
			    		<label>{{__('messages.status')}}</label>
				    	<select class="form-control col-11 @error('available') is-invalid @enderror" name="available" required>
				    		<option></option>
				    		@foreach($data['busAvailableType'] as $row)
				    			<option value="{{$row->id}}">{{__('messages.'.$row->name)}}</option>
				    		@endforeach
				    	</select>
				    	<sup class="text-danger"><i class="bi bi-star-fill"></i></sup>
				    	@error('available')
				    		<div class="text-danger">{{$message}}</div>
				    	@enderror
				    </div>
			    	
			   	</div>
		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
		        <button class="btn btn-success">{{__('messages.save')}}</button>
		    </div>
		</form>
	</div>
  </div>
</div>




<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form method="POST" action="{{route('partner.bus.buses.delete',app()->getLocale())}}">
    		@csrf
		    <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.delete')}}</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    <div class="modal-body">
		    	<input type="hidden" name="bus" value="" id="busvalue">
		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
		        <button class="btn btn-danger">{{__('messages.delete')}}</button>
		    </div>
		</form>
	</div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form method="POST" action="{{route('partner.bus.buses.postedit',app()->getLocale())}}">
    		@csrf
		    <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.edit')}}</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		    </div>
		    <div class="modal-body" id="editModalBody">
		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
		        <button class="btn btn-success">{{__('messages.save')}}</button>
		    </div>
		</form>
	</div>
  </div>
</div>

<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  		<form action="{{route('partner.bus.buses.add',app()->getLocale() )}}" method="POST">
  			@csrf
  			<input type="hidden" name="company" value="{{$data['company']->id??''}}">

  			
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
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
		        <button class="btn btn-primary">{{__('messages.save')}}</button>
		      </div>
		    </div>
		</form>
  </div>
</div>
@endsection