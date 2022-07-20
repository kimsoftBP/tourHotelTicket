@extends('partner.view')
@section('subincludecontent')
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
	function setdelete(id){
		$("#deleteMenu").val(id);
	}
	function loadEdit(id){
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		 $.ajax({
		   type:'post',
		   url:'{{route('partner.restaurant.menu.getEdit', app()->getLocale())}}',
		   data:{_token: CSRF_TOKEN, "rid":id
	       			},
		 //  data:'_token = <?php echo csrf_token() ?>',
		   success:function(data) {
		     // $("#country2").html(data.msg);
		     $("#editModalBody").html(data.html);
		   }
		});
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

	<button class="btn btn-primary"  class="btn btn-primary" data-toggle="modal" data-target="#addModal">+</button>
	<table class="table">
		<tr>
			<th></th>
			<th>{{__('messages.title')}}</th>
			<th>{{__('messages.price')}}</th>
		</tr>
		@foreach($data['restaurant']->Menu as $row)
			<tr>
				<td>
					<button class="btn btn-info"  class="btn btn-primary" data-toggle="modal" data-target="#editModal" onclick="loadEdit({{$row->id}})">{{__('messages.edit')}}</button>
					<button class="btn btn-danger" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal" onclick="setdelete({{$row->id}})">{{__('messages.delete')}}</button>
				</td>
				<td>{{$row->title}}</td>
				<td>{{$row->price}}  {{$row->currency->html}}</td>
			</tr>
		@endforeach
	</table>
</div>
@endsection
@section('submodalconent')
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<form action="{{route('partner.restaurant.menu.add',app()->getLocale())}}" method="POST">
  		@csrf
  		<input type="hidden" name="rid" value="{{$data['restaurant']->id}}">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" id="addModalBody">
	        	<div class="form-group">
	        		<label>{{__('messages.title')}}</label>
	        		<input type="text" name="title" value="{{old('title')}}" class="form-control">
	        		@error('title')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>
	        	<div class="form-group">
	        		<label>{{__('messages.text')}}</label>
	        		<textarea class="form-control" name="text">{{old('text')}}</textarea>
	        		@error('text')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>
	        	<div class="form-group">
	        		<label>{{__('messages.price')}}</label>
	        		<input type="number" name="price" value="{{old('price')}}" class="form-control">
	        		@error('price')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>
	        	<div class="form-group">
	        		<label>{{__('messages.currency')}}</label>
	        		<select class="form-control" name="currency">
	        			<option></option>
	        			@foreach($data['currency'] as $currency)
	        				<option value="{{$currency->id}}">{!!$currency->html!!}</option>
	        			@endforeach
	        		</select>
	        	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button  class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	</form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<form action="{{route('partner.restaurant.menu.postedit',app()->getLocale())}}" method="POST">
  		@csrf
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.editroom')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" id="editModalBody">
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button  class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	</form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<form action="{{route('partner.restaurant.menu.delete',app()->getLocale())}}" method="POST">
  		@csrf
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.delete')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" id="deleteModalBody">
	        <input type="hidden" name="menu" value="" id="deleteMenu">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
	        <button  class="btn btn-primary">{{__('messages.delete')}}</button>
	      </div>
	    </div>
	</form>
  </div>
</div>
@endsection