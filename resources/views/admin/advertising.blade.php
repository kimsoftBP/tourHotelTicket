@extends('admin.view')
@section('subincludecontent')

<script type="text/javascript" >
	function deleteadvertising(id){
		$("#deleteadvertising").val(id);
		$("#deleteModal").modal('show');
	}

	function showedit(cname){
		$.ajax({
           type:'get',
           //url:'/en/hotel/admin/room/edit',
           url:'{{route('admin.advertising.edit',app()->getLocale())}}',
           data:{"advertising":cname
       			},
         //  data:'_token = <?php echo csrf_token() ?>',
           success:function(data) {
              $("#editmodalcontent").html(data.msg);
              //$("#city").removeAttr('disabled');
           }
        });

		$("#editModal").modal('show');
	//	$("#citymodal").trigger('focus');
		//$("#myLargeModalLabel").show();
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
	<button class="btn btn-primary"  data-toggle="modal" data-target="#addModal">+</button>
	<table class="table table-hover">
		<tr>
			<th></th>
			<th>{{__('messages.name')}}</th>
			<th>{{__('messages.from')}}</th>
			<th>{{__('messages.to')}}</th>
			<th>{{__('messages.position')}}</th>
		</tr>
		@foreach($data['advertising'] as $row)
			<tr>
				<td>
					<button class="btn btn-primary" onclick="showedit({{$row->id}})">{{__('messages.edit')}}</button>
					<button class="btn btn-danger" onclick="deleteadvertising({{$row->id}})">{{__('messages.delete')}}</button>
				</td>
				<td>{{$row->name}}</td>
				<td>{{$row->available_start}}</td>
				<td>{{$row->available_end}}</td>
				<td>
						{{$row->include->first()->position->page}}/
						{{$row->include->first()->position->name}}
				</td>
				<td>
					@if($row->file!=NULL)
					<img src="{{$row->path}}/{{$row->file}}">
					@endif
				</td>
			</tr>
		@endforeach
	</table>


	@php
		$from=$data['page']-2;
		$to=$data['pages'];
	@endphp
	<nav aria-label="Page navigation example">
	  <ul class="pagination justify-content-center">
	    <li class="page-item {{$data['page']<=1 ? 'disabled':''}}"><a class="page-link" href="?page={{$data['page']-1}}&{{$data['url']}}">Previous</a></li>
	    @for($i=$from;$i<=$to;$i++)
	    	<li class="page-item {{$data['page']==$i ? 'disabled':''}}"><a class="page-link" href="#">{{$i}}</a></li>	    
	    @endfor
	    <li class="page-item {{$data['page']>=$data['pages'] ? 'disabled':''}} "><a class="page-link" href="?page={{$data['page']+1}}&{{$data['url']}}">Next</a></li>
	  </ul>
	</nav>
</div>

@endsection
@section('submodalconent')


<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form action="{{route('admin.advertising.add',app()->getLocale())}}" method="post" enctype="multipart/form-data">
    		@csrf
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
	        	<label>{{__('messages.name')}}</label>
	        	<input type="text" name="name" value="{{old('name')}}" class="form-control">
	        	@error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
	        </div>
	        <div class="form-group">
	        	<label>{{__('messages.from')}}</label>
	        	<input type="date" name="from" value="{{old('from')}}" class="form-control">
	        	@error('from')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
	        </div>
	        <div class="form-group">
	        	<label>{{__('messages.to')}}</label>
	        	<input type="date" name="to" value="{{old('to')}}" class="form-control">
	        	@error('to')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
	        </div>
	        <div class="form-group">
		        <select name="position" class="form-control">
		        	@foreach($data['position'] as $row)
		        		<option value="{{$row->id}}">{{$row->page}}/ {{$row->name}} 
		        		({{__('messages.text')}} {{__('messages.maxrows')}}  {{$row->text_max_rows}} {{__('messages.maxlinelength')}} {{$row->text_max_colums}})</option>
		        	@endforeach
		        </select>
		    	</div>
		    	<div class="form-group">
		    		<label>{{__('messages.url')}}</label>
		    		<input type="text" name="url" value="{{old('url')}}" class="form-control">
		    		@error('url')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
		    	</div>
		    	<div class="form-group">
		    		<label>{{__('messages.text')}}</label>
		    		<textarea name="text" rows="4" columns="10" class="form-control">{{old('text')}}</textarea>
		    		@error('text')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
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
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
	        <button class="btn btn-primary">{{__('messages.save')}}</button>
	      </div>
	  	</form>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form action="{{route('admin.advertising.delete',app()->getLocale())}}" method="post" enctype="multipart/form-data">
    		@csrf
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.delete')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <input type="hidden" name="advertising" value="" id="deleteadvertising">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
	        <button  class="btn btn-danger">{{__('messages.delete')}}</button>
	      </div>
	    </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form action="{{route('admin.advertising.edit',app()->getLocale())}}" method="post" enctype="multipart/form-data">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.edit')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" id="editmodalcontent">
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
	        <button  class="btn btn-primary">{{__('messages.save')}}</button>
	      </div>
	    </form>
    </div>
  </div>
</div>
@endsection