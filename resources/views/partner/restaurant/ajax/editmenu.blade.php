	        	<div class="form-group">
	        		<label>{{__('messages.title')}}</label>
	        		<input type="text" name="title" value="{{old('title',$data['menu']->title)}}" class="form-control">
	        		@error('title')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>
	        	<div class="form-group">
	        		<label>{{__('messages.text')}}</label>
	        		<textarea class="form-control" name="text">{{old('text',,$data['menu']->text)}}</textarea>
	        		@error('text')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>
	        	<div class="form-group">
	        		<label>{{__('messages.price')}}</label>
	        		<input type="number" name="price" value="{{old('price',$data['menu']->price)}}" class="form-control">
	        		@error('price')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>
	        	<div class="form-group">
	        		<label>{{__('messages.currency')}}</label>
	        		<select class="form-control" name="currency">
	        			<option></option>
	        			@foreach($data['currency'] as $currency)
	        				<option value="{{$currency->id}}" {{$data['menu']->currencyid==$currency->id ? 'selected':''}}>{!!$currency->html!!}</option>
	        			@endforeach
	        		</select>
	        	</div>