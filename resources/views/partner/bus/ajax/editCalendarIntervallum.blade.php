	<div class="form-group row">
		<input type="hidden" name="editAvailable" value="{{$data['available']->id}}">
    	<label class="col-form-label col-12">{{__('messages.from')}}</label>
    	<div class="col-5 row">
    		<input type="date" name="fromDate" class="col-11 form-control @error('fromDate') is-invalid @enderror" required value="{{old('fromDate',$data['available']->date)}}">
    		<sup class="text-danger"><i class="bi bi-star-fill"></i></sup>
    		@error('fromDate')
    			<div class="text-danger">{{$message}}</div>
    		@enderror
    	</div>
    	<div class="col-5">
    		<input type="time" name="fromTime" class="form-control @error('fromTime') is-invalid @enderror" value="{{old('fromTime',$data['available']->from_time)}}">
    		@error('fromTime')
    			<div class="text-danger">{{$message}}</div>
    		@enderror
    	</div>
    	<label class="col-form-label col-12">{{__('messages.to')}}</label>

    	<div class="col-5 row">
    		<input type="date" name="toDate" class="col-11 form-control @error('toDate') is-invalid @enderror" required  value="{{old('toDate',$data['available']->to_date)}}">
    		<sup class="text-danger"><i class="bi bi-star-fill"></i></sup>
    		@error('toDate')
    			<div class="text-danger">{{$message}}</div>
    		@enderror
    	</div>
    	<div class="col-5">
    		<input type="time" name="toTime" class="form-control @error('toTime') is-invalid @enderror" value="{{old('toTime', $data['available']->to_time)}}">
    		@error('toTime')
    			<div class="text-danger">{{$message}}</div>
    		@enderror
    	</div>

    	<div class="col-8 mt-2 row">
	    	<select class="form-control col-11 @error('available') is-invalid @enderror" name="available" required>
	    		<option></option>
	    		@foreach($data['busAvailableType'] as $row)
	    			<option value="{{$row->id}}" {{old('available',$data['available']->bus_available_typeid)==$row->id ? 'selected':''}} >{{__('messages.'.$row->name)}}</option>
	    		@endforeach
	    	</select>
	    	<sup class="text-danger"><i class="bi bi-star-fill"></i></sup>
	    	@error('available')
	    		<div class="text-danger">{{$message}}</div>
	    	@enderror
	    </div>
    	
   	</div>