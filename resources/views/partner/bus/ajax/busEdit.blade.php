				<input type="hidden" name="bus" value="{{$data['bus']->id}}">
				<div class="form-group">
		        	<label>{{__('messages.brand')}}</label>
		        	<input type="text" name="brand" class="form-control" list="brand" value="{{old('brand',$data['bus']->BusType->brand)}}">
		        	@error('brand')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>
		        <div class="form-group">
		        	<label>{{__('messages.model')}}</label>
		        	<input type="text" name="model" class="form-control" value="{{old('model',$data['bus']->BusType->name)}}">
		        	@error('model')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>
		        <div class="form-group">
		        	<label>{{__('messages.year')}}</label>
		        	<select name="year" class="form-control">		    
		        		<option></option>    		
		        		@for($i=0;$i<10;$i++)
		        			<option value="{{$data['year']-$i}}" {{old('year',$data['bus']->year)==($data['year']-$i )? 'selected':''}} >{{$data['year']-$i}}</option>
		        		@endfor
		        	</select>
		        	@error('year')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>
		        <div class="form-group">
		        	<label>{{__('messages.licensePlate')}}</label>
		        	<input type="text" name="licensePlate" class="form-control" value="{{old('licensePlate',$data['bus']->license_plate)}}">
		        	@error('licensePlate')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>
		        <div class="form-group">
		        	<label>{{__('messages.seat')}}</label>
		        	<input type="text" name="seat" class="form-control" value="{{old('seat',$data['bus']->passenger_seats)}}">
		        	@error('seat')
		        		<div class="text-danger">{{$message}}</div>
		        	@enderror
		        </div>