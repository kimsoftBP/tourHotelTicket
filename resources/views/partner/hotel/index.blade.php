@extends('partner.view')
@section('subincludecontent')
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
	function deleteRoom(id){
		$("#deleteRoomid").val(id);
	}
	function loadEditRoom(id){
		//editModalBody
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		 $.ajax({
		   type:'post',
		   url:'{{route('partner.hotel.room.edit', app()->getLocale())}}',
		   data:{_token: CSRF_TOKEN, "rid":id
	       			},
		 //  data:'_token = <?php echo csrf_token() ?>',
		   success:function(data) {
		     // $("#country2").html(data.msg);
		     $("#editModalBody").html(data.html);
		   }
		});
	}
	function loadCalendar(id,year,month){
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		 $.ajax({
		   type:'post',
		   url:'{{route('partner.hotel.room.getcalendar', app()->getLocale())}}',
		   data:{_token: CSRF_TOKEN, "rid":id,'year':year,'month':month
	       			},
		 //  data:'_token = <?php echo csrf_token() ?>',
		   success:function(data) {
		     // $("#country2").html(data.msg);
		     $("#calendarModalBody").html(data.html);
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

	<button class="btn btn-primary" lass="btn btn-primary" data-toggle="modal" data-target="#addRoomModal">{{__('messages.addRoom')}}</button>
	<table class="table table-hover">
		<tr>
			<th></th>
			<th></th>
			<th>{{__('messages.piece')}}</th>
			<th>{{__('messages.maximumPeople')}}</th>
		</tr>
		@foreach($data['hotelroom'] as $row)
			<tr>
				<td>
					<button class="btn btn-info" class="btn btn-primary" data-toggle="modal" data-target="#editRoomModal" onclick="loadEditRoom({{$row->id}})">{{__('messages.edit')}}</button>
					<button class="btn btn-primary" data-toggle="modal" data-target="#calendarModal"  onclick="loadCalendar({{$row->id}})">{{__('messages.calendar')}}</button>
					<button class="btn btn-danger" class="btn btn-primary" data-toggle="modal" data-target="#deleteRoomModal" onclick="deleteRoom({{$row->id}})">{{__('messages.delete')}}</button>
					
				</td>
				<td>{{$row->name}}</td>
				<td>{{$row->piece}}</td>
				<td>{{$row->maximum_people}}</td>
			</tr>
		@endforeach
	</table>
</div>
@endsection
@section('submodalconent')

<!-- Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form action="{{route('partner.hotel.room.add',app()->getLocale())}}" method="POST">
		@csrf
		<input type="hidden" name="hid" value="{{$data['hotel']->id}}">

	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.addRoom')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      		<div class="form-group">
	      			<label>{{__('messages.name')}}</label>
	      			<input type="text" name="name" value="{{old('name')}}" class="form-control">
	      			@error('name')
	      				<div class="text-danger">{{$message}}</div>
	      			@enderror
	      		</div>
	        	<div class="form-group">
	        		<label>{{__('messages.maximumPeople/room')}}</label>
	        		<input type="number" name="people" value="{{old('people')}}" min="1" class="form-control">
	        		@error('people')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>
	        	<div class="form-group">
	        		<label>{{__('messages.piece')}}</label>
	        		<input type="number" name="piece" value="{{old('piece')}}" min="1" class="form-control">
	        		@error('piece')
	        			<div class="text-danger">{{$message}}</div>
	        		@enderror
	        	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
	        <button  class="btn btn-primary">{{__('messages.save')}}</button>
	      </div>
	    </div>
	  </div>
	</form>
</div>



<!-- Modal -->
<div class="modal fade" id="editRoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<form action="{{route('partner.hotel.room.postedit',app()->getLocale())}}" method="POST">
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
<div class="modal fade" id="deleteRoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<form action="{{route('partner.hotel.room.delete',app()->getLocale() )}}" method="POST">
  		@csrf
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.deleteRoom')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <input type="hidden" name="rid" value="" id="deleteRoomid">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
	        <button  class="btn btn-danger">{{__('messages.delete')}}</button>
	      </div>
	    </div>
	</form>
  </div>
</div>




<!-- Modal -->
<div class="modal fade rbd-example-modal-lg" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  	<form action="{{route('partner.hotel.room.postcalendar',app()->getLocale())}}" method="POST">
  		@csrf
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.available')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" id="calendarModalBody">
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button  class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	</form>
  </div>
</div>

@endsection