@extends('admin.view')
@section('subincludecontent')
<style type="text/css">
	.offer-type-wrap {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 8;
}
</style>
<script>
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

        function mydelete(id){
		
		if($("#d"+id).prop('checked')==true){
			$("#"+id).hide();
			//$("#d"+id).checked;
			$("#d"+id).prop('checked', false);
		//	$("#d"+id).val(0);
		}else{
			$("#"+id).show();
			//document.getElementById("#d"+id).checked =true;
			$("#d"+id).prop('checked', true);
			//$("#d"+id).val(true);
		}
		
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
	<form action="{{ route('admin.cities.edit', app()->getLocale()) }}" method="post" enctype="multipart/form-data" >
		@csrf
		<input type="hidden" name="cityid" value="{{$data['city']->id}}">
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
	        		<input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{old('city',$data['city']->name)}}">
	        		@error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
	        	</div>
	        	<span class="" id="basic-addon2">{{__('messages.image')}}</span>
	        	<br>1920x500 pixel
	        	<div>
	        	@foreach($data['city']->photos()->where('notes','cover')->get() as $row)
					<div class="col-md-6 col-lg-4 mb-4" style="margin: 0px;float: left;">
			             <div class="property-entry h-100">	
					     	<div class="offer-type-wrap">       
					     		<span id="{{$row->id}}" class="offer-type bg-danger" style="display: none;">{{__('messages.delete')}}</span>
					     		{{--<input type="hidden" id="d{{$row->id}}" name="{{$row->id}}" value="0">--}}
					     	</div>
					     	
					       	<img src="{{$row->folder}}/{{$row->name}}" alt="Image" class="img-fluid" style="max-width: 420px ; max-height: 420px;" onclick="mydelete({{$row->id}})">
					       	<input type="checkbox" id="d{{$row->id}}" name="d{{$row->id}}">
					     </div>       
					 </div>
	        	@endforeach
	        	</div>
	        	<!-- {{--
	        	 foreach($advertising->images as $row)
	        	
		     <div class="col-md-6 col-lg-4 mb-4" style="margin: 0px;float: left;">
	             <div class="property-entry h-100">	
			     	<div class="offer-type-wrap">       
			     		<span id="{{$row->id}}" class="offer-type bg-danger" style="display: none;">{{__('messages.delete')}}</span>
			     		{{--<input type="hidden" id="d{{$row->id}}" name="{{$row->id}}" value="0">--}}
			     	</div>
			       	<img src="" alt="Image" class="img-fluid" style="max-width: 120px ; max-height: 120px;" onclick="mydelete(56)">
			       	<input type="checkbox" id="d2" name="d2">d(id)
			     </div>       
			 </div>
                    
            
            --}} -->
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
	        	<div>
	        	@foreach($data['city']->photos()->where('notes','small')->get() as $row)
					<div class="col-md-6 col-lg-4 mb-4" style="margin: 0px;float: left;">
			             <div class="property-entry h-100">	
					     	<div class="offer-type-wrap">       
					     		<span id="{{$row->id}}" class="offer-type bg-danger" style="display: none;">{{__('messages.delete')}}</span>
					     		{{--<input type="hidden" id="d{{$row->id}}" name="{{$row->id}}" value="0">--}}
					     	</div>
					     	
					       	<img src="{{$row->folder}}/{{$row->name}}" alt="Image" class="img-fluid" style="max-width: 220px ; max-height: 220px;" onclick="mydelete({{$row->id}})">
					       	<input type="checkbox" id="d{{$row->id}}" name="d{{$row->id}}">
					     </div>       
					 </div>
	        	@endforeach
	        	</div>
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
	        	<input type="submit" name="submit" value="{{__('messages.save')}}" class="btn btn-primary">
	</form>
</div>
@endsection