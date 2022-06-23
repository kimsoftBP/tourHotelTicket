@extends('admin.view')
@section('subincludecontent')
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
     <script>
         function getRegion() {
            $.ajax({
               type:'get',
               url:'/en/admin/region',
               data:{"id":$('#continent').val() 
           			},
             //  data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                  $("#region").html(data.msg);
                  $("#country").html("");
               }
            });
         }
		function getCountry() {
            $.ajax({
               type:'get',
               url:'/en/admin/country',
               data:{"id":$('#region').val() 
           			},
             //  data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                  $("#country").html(data.msg);
               }
            });
         }

        function getRegion2() {
            $.ajax({
               type:'get',
               url:'/en/admin/region',
               data:{"id":$('#continent2').val() 
           			},
             //  data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                  $("#region2").html(data.msg);
                  $("#country2").html("");
               }
            });
         }
		function getCountry2() {
            $.ajax({
               type:'get',
               url:'/en/admin/country',
               data:{"id":$('#region2').val() 
           			},
             //  data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                  $("#country2").html(data.msg);
               }
            });
         }
         function showdeletemodal(id){			
         	$('#deletecity').val(id);

         }
      </script>
@endsection
@section('subcontent')
<div style="z-index: 1;">
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
	{{--
	<form action="{{ route('registerp', app()->getLocale()) }}" method="post" enctype="multipart/form-data" >
		--}}
	<form>
		<div class="input-group mb-3">
			
			<select class="custom-select " name="continent" id="continent" onchange="getRegion()">
				<option selected value="">Choose...</option>
				@foreach($data['continent'] as $continent)
					<option value="{{$continent->name}}" {{$continent->name==$data['searchcontinent'] ? 'selected':''}}>{{$continent->name}}</option>
				@endforeach
			</select>

			<select class="custom-select " name="region" id="region" onchange="getCountry()">
				@if($data['region']!=NULL)
					<option value="">Choose...</option>
					@foreach($data['region'] as $region)
						<option value='{{$region->name}}' {{$region->name==$data['searchregion'] ? 'selected':''}}>{{$region->name}}</option>
					@endforeach
				@endif
			</select>
			<select class="custom-select" name="country" id="country">
				@if($data['country']!=NULL)
					<option value="">Choose...</option>
					@foreach($data['country'] as $country)
						<option value="{{$country->name}}" {{$country->name==$data['searchcountry'] ? 'selected':''}}>{{$country->name}}</option>
					@endforeach
				@endif
			</select>

			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		</div>
	</form>
	<div>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
		+</button>
		<div>
			<table class="table">
			@if(isset($data['cities']))
				@foreach($data['cities'] as $city)
					<tr>
						<td><a href="{{route('admin.cities.edit',['locale'=>app()->getLocale(),'city'=>$city->id ])}}" class="btn btn-primary">Edit</a>
							<button class="btn btn-danger" onclick="showdeletemodal({{$city->id}})"  data-toggle="modal" data-target="#deleteModal">{{__('messages.delete')}}</button>
						</td>
						<td>{{$city->name}}</td>
					</tr>
				@endforeach
			@endif
			</table>
		</div>
	</div>

	@php
		$from=1;
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

<style type="text/css">
	.modal{
		z-index: 999 !important;
	}
	.modal-content {
    margin: 2px auto;
    z-index: 1100 !important;
}
	.modal-backdrop {
		z-index: 1 !important;
		/*display: none;*/
	}
</style>



@endsection
@section('submodalconent')
<div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog col-10" role="document">
	  	<form action="{{ route('admin.cities.add', app()->getLocale()) }}" method="post" enctype="multipart/form-data" >
	  		@csrf
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle">{{__('messages.addnewcity')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		      	<select class="custom-select col-lg-3 float-left @error('continent') is-invalid @enderror" name="continent" id="continent2" onchange="getRegion2()">
					<option value="">Choose...</option>
					@foreach($data['continent'] as $continent)
						<option value="{{$continent->name}}" {{$continent->name==$data['searchcontinent'] ? 'selected':''}}>{{$continent->name}}</option>
					@endforeach
				</select>
				
				<select class="custom-select col-lg-3 float-left @error('region') is-invalid @enderror" name="region" id="region2" onchange="getCountry2()">
					@if($data['region']!=NULL)
						<option value="">Choose...</option>
						@foreach($data['region'] as $region)
							<option value='{{$region->name}}' {{$region->name==$data['searchregion'] ? 'selected':''}}>{{$region->name}}</option>
						@endforeach
					@endif
				</select>
				
				<select class="custom-select col-lg-3 @error('country') is-invalid @enderror" name="country" id="country2">
					@if($data['country']!=NULL)
						<option value="">Choose...</option>
						@foreach($data['country'] as $country)
							<option value="{{$country->name}}" {{$country->name==$data['searchcountry'] ? 'selected':''}}>{{$country->name}}</option>
						@endforeach
					@endif
				</select>
				

				@error('continent')
                    <span class="invalid-feedback" role="alert" style="display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                    
                @enderror
				@error('region')
                    <span class="invalid-feedback" role="alert" style="display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                    
                @enderror
				@error('country')
                    <span class="invalid-feedback" role="alert" style="display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            	
            	<br><br>
	        	<div class="input-group mb-3 ">
	        		<div class="input-group-append">
					    <span class="input-group-text" id="basic-addon2">{{__('messages.city')}}</span>
					  </div>
	        		<input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{old('city')}}">
	        		@error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
	        	</div>
	        	<span class="" id="basic-addon2">{{__('messages.image')}}</span>
	        	<br>1920x500 pixel
	        	<div class="input-group mb-3 ">
	        		<div class="input-group-append">
					</div>
	        		<input type="file" name="image" class="form-control  @error('image') is-invalid @enderror">
	        		@error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
	        	</div>
	        	<span class="" id="basic-addon2">{{__('messages.imagesmall')}}</span>
	        	<br>500x500 pixel
	        	<div class="input-group mb-3 ">
	        		<div class="input-group-append">
					</div>
	        		<input type="file" name="imagesmall" class="form-control  @error('imagesmall') is-invalid @enderror">
	        		@error('imagesmall')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
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
</div>






<div>
	<!-- Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog col-10" role="document">
	  	<form action="{{ route('admin.cities.delete', app()->getLocale()) }}" method="post" enctype="multipart/form-data" >
	  		@csrf
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle">{{__('messages.deletecity')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		      	<input type="hidden" name="city" id="deletecity">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button  class="btn btn-primary">{{__('messages.delete')}}</button>
	      </div>
	    </div>
		</form>
	  </div>
	</div>
</div>

@endsection