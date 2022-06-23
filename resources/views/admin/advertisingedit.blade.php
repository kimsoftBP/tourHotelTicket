	        <input type="hidden" name="advertising" value="{{$data['advertising']->id}}">
	        @csrf
	        <div class="form-group">
	        	<label>{{__('messages.name')}}</label>
	        	<input type="text" name="name" value="{{old('name',$data['advertising']->name)}}" class="form-control">
	        	@error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
	        </div>
	        <div class="form-group">
	        	<label>{{__('messages.from')}}</label>
	        	<input type="date" name="from" value="{{old('from',$data['advertising']->available_start)}}" class="form-control">
	        	@error('from')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
	        </div>
	        <div class="form-group">
	        	<label>{{__('messages.to')}}</label>
	        	<input type="date" name="to" value="{{old('to',$data['advertising']->available_end)}}" class="form-control">
	        	@error('to')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
	        </div>
	       	<div class="form-group">
		        <select name="position" class="form-control">
		        	@foreach($data['position'] as $row)
		        		<option value="{{$row->id}}" 
		        			{{--$data['advertising']->include->first()->advertisingpositionid==$row->id ?? 'selected':'' --}}

		        			>{{$row->page}}/ {{$row->name}}  ({{__('messages.text')}} {{__('messages.maxrows')}}  {{$row->text_max_rows}} {{__('messages.maxlinelength')}} {{$row->text_max_colums}})</option>
		        	@endforeach
		        </select>
		    </div>
			<div class="form-group">
		    		<label>{{__('messages.url')}}</label>
		    		<input type="text" name="url" value="{{old('url',$data['advertising']->url)}}" class="form-control">
		    		@error('url')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
	    	</div>
	    	<div class="form-group">
		    		<label>{{__('messages.text')}}</label>
		    		<textarea name="text" rows="4" columns="10" class="form-control">{{old('text',$data['advertising']->text)}}</textarea>
		    		@error('text')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
	    	</div>		  

	        <div>
	        	@php
	        		$img=$data['advertising']->files->first();
	        	@endphp
	        	@if($img!=NULL)
		        	<label></label>
		        	<img src="{{$img->path}}{{$img->name}}" style="max-width:200px;max-height: 200px;">
		        @endif
	        </div>

	        <div class="form-group">
	        	<label>{{__('messages.file')}}</label>
	        	<input type="file" name="file[]" class="form-control">
	        	@error('file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
	        </div>
	      </div>