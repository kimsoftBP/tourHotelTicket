	     <input type="hidden" name="rid" value="{{$data['room']->id}}">
	      		<div class="form-group">
	      			<label>{{__('messages.name')}}</label>
	      			<input type="text" name="name" value="{{$data['room']->name}}" class="form-control">
	      			@error('name')
	      				<div class="text-danger">{{$message}}</div>
	      			@enderror
	      		</div>
	        	<div class="form-group">
	        		<label>{{__('messages.maximumPeople/room')}}</label>
	        		<input type="number" name="people" value="{{$data['room']->maximum_people}}" min="1" class="form-control">
	        		@error('people')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>
	        	<div class="form-group">
	        		<label>{{__('messages.piece')}}</label>
	        		<input type="number" name="piece" value="{{$data['room']->piece}}" min="1" class="form-control">
	        		@error('piece')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>