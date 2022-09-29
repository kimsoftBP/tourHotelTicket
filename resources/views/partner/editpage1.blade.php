@extends('partner.view')
@section('subincludecontent')
<script type="text/javascript">
	$( document ).ready(function() {
		getCitydefault();
	});
</script>
<script type="text/javascript">
		function getCitydefault() {
            $.ajax({
               type:'get',
               //url:'/en/partner/city',
               url:'{{route('partner.ajaxcity',app()->getLocale())}}',
               data:{"id":$('#country').val() ,
               		'old':'{{old('city',$data['productcity'])}}'
           			},
             //  data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                  $("#city").html(data.msg);
                  $("#city").removeAttr('disabled');
               }
            });
        }
		function getCity() {
            $.ajax({
               type:'get',
               //url:'/en/partner/city',
               url:'{{route('partner.ajaxcity',app()->getLocale())}}',
               data:{"id":$('#country').val()
           			},
             //  data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                  $("#city").html(data.msg);
                  $("#city").removeAttr('disabled');
               }
            });
         }
        function rmparent(em){
        	$(em).parent().remove()
        	console.log("rm");
        }
        function minimumnumber() {
        	if($("#toursize").val()=={{$data['toursizegroup']->id}} ){
        		$("#minimumnumberofdepartures").show();
        	}else{
        		$("#minimumnumberofdepartures").hide();
        	}
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
<style>
	.containerdivNewLine { clear: both; float: left; display: block; position: relative; } 

	.pcir{
		color: #62a8ea;
	    background-color: #fff;
	    border-color: #62a8ea;
	    -webkit-transform: scale(1.3);
	    -ms-transform: scale(1.3);
	    -o-transform: scale(1.3);
	    transform: scale(1.3);

	}
	.pnum{
	    position: relative;
		
	    z-index: 1;
	    display: inline-block;
	    width: 36px;
	    height: 36px;
	    line-height: 32px;
	    color: black;
	    text-align: center;
	    background-color: white;
	    /*background: #ccd5db;
	   */ 
	    border: 2px solid #ccd5db;
	    border-radius: 50%;
	        font-size: 18px;
	}

.property-entry .offer-type-wrap {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 8;
}
</style>
<style type="text/css">
.pearl {
    position: relative;
    padding: 0;
    margin: 0;
    text-align: center;
}
.pearl.current .pearl-number, .pearl.current .pearl-icon {
    color: #62a8ea;
    background-color: #fff;
    border-color: #62a8ea;
    -webkit-transform: scale(1.3);
    -ms-transform: scale(1.3);
    -o-transform: scale(1.3);
    transform: scale(1.3);
}
.pearl-number {
    font-size: 18px;
}
.pearl-number, .pearl-icon {
    position: relative;
    z-index: 1;
    display: inline-block;
    width: 36px;
    height: 36px;
    line-height: 32px;
    color: #fff;
    text-align: center;
    background: #ccd5db;
    border: 2px solid #ccd5db;
    border-radius: 50%;
}
.pearl.current:before, .pearl.current:after {
    background-color: #62a8ea;
}
.pearl:before {
    left: 0;
}

.pearl:before, .pearl:after {
    position: absolute;
    top: 18px;
    z-index: 0;
    width: 50%;
    height: 4px;
    content: "";
    background-color: #f3f7f9;
}
.pearl-title {
    display: block;
    margin-top: .5em;
    margin-bottom: 0;
    overflow: hidden;
    font-size: 16px;
    color: #526069;
    text-overflow: ellipsis;
    word-wrap: normal;
    white-space: nowrap;
}
</style>
@endsection
@section('subcontent')
<div>

	<div class="col-lg-9 col-xl-9">
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
		<div style="margin-bottom: 20px;">
			<!--
			<div class="">
				<a href="" class="pnum">1</a>
			</div>-->
			

			<div class="pearls row" data-by-row="true" data-plugin="matchHeight" role="tablist">
				<div class="col-4 col-xs-4 current pearl" data-target="#step1" role="tab" style="">
					<span class="pearl-number" >1</span>
					<span class="pearl-title">
					<a href="/partner/offers/103831/edit?step=1">{{__('messages.basicinformation')}}</a>
					</span>
				</div>
				<div class="col-4 col-xs-4  pearl" data-target="#step2" role="tab">
					<a class="pearl-number" href="{{route('partner.product.editpage2',['locale'=>app()->getLocale(),'product'=>$data['product']->id] )}}">2</a>
					<span class="pearl-title">
					<a href="{{route('partner.product.editpage2',['locale'=>app()->getLocale(),'product'=>$data['product']->id] )}}">{{__('messages.courseinformation')}}</a>
					</span>
				</div>
				<div class="col-4 col-xs-4 pearl" data-target="#step3" role="tab">
					<a class="pearl-number" href="{{route('partner.product.editpage3',['locale'=>app()->getLocale(),'product'=>$data['product']->id] )}}">3</a>
					
					<span class="pearl-title">
					<a href="{{route('partner.product.editpage3',['locale'=>app()->getLocale(),'product'=>$data['product']->id] )}}">{{__('messages.priceinformation')}}</a>
					</span>
				</div>
			</div>
			<!--
			<div class="col-2  text-center border rounded-circle" style="color: black;height: 50px;width: 50px;">
			  	<h5 class="align-middle ">1</h5>
			</div>
			<div class="progress">
				
			  <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
			  	
			  </div>
			</div>-->
		</div>

		<form action="{{ route('partner.product.editpage1', app()->getLocale()) }}" method="post" enctype="multipart/form-data" >

				@csrf
				<input type="hidden" name="product" value="{{$data['product']->id}}">
			<div class="form-group">
			    <h5><label for="">{{__('messages.country/city')}}</label></h5>
			    @php
			    	$tempcountry="";
			    	if(isset($data['product']->country->name)){
			    		$tempcountry=$data['product']->country->name;
			    	}			    
			    @endphp
			    <div class="input-group">
			    	<div class="form-group col-lg-6">
					    <select class="form-control  @error('country') is-invalid @enderror" style="margin-right: 20px;" onchange="getCity()" id="country" name="country">
					    	<option value=""></option>
					    	 @foreach($data['country'] as $country)
					    	 	<option value="{{$country->name}}" {{old('country',$tempcountry)==$country->name ? 'selected':''}}>{{__('messages.'.$country->name)}}</option>
					    	 @endforeach
					    </select>
					    @error('country')
		                    <span class="invalid-feedback" role="alert" style="display: block;">
		                        <strong>{{ $message }}</strong>
		                    </span>
                		@enderror
					</div>
					<div class="form-group col-lg-6">
					    <select class="form-control  @error('city') is-invalid @enderror" id="city" name="city" disabled>
					    	
					    </select>
					</div>
				</div>
			    <small id="emailHelp" class="form-text text-muted"></small>
			    <div class="form-check">
			    	<input type="checkbox" class="form-check-input  @error('nocity') is-invalid @enderror" id="nocity" name="nocity" value="1" {{old('nocity',$data['product']->nocity)==true ? 'checked':''}}>
			    	<label class="form-check-label" for="nocity">{{__('messages.noapplicablecity')}}</label>
			    	@error('nocity')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
                	@enderror
	  			</div>
			</div>
			<div>
				<h5><label>{{__('messages.category')}}</label></h5>
				
				@php $i=0; 
					$tempcategory="";
					if(isset($data['product']->category->name)){
						$tempcategory=$data['product']->category->name;
					}

				@endphp
				@foreach($data['category'] as $category)
					<div class="form-check form-check-inline fdorm-group">
						<input class="form-check-input" type="radio" name="category" value="{{$category->name}}" id="category{{$i}}" {{old('category',$tempcategory)==$category->name ? 'checked':''}} >
						<label class="form-check-label" for="category{{$i}}">{{__('messages.'.$category->name)}}</label>
					</div>
					@php  $i++; @endphp
				@endforeach
				@error('category')
                    <span class="invalid-feedback" role="alert" style="display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
            	@enderror
			</div>
			<br>
			<div>				
				<h5><label>{{__('messages.language')}}</label></h5>
				<select class="form-control  @error('language') is-invalid @enderror" multiple aria-label="multiple select language" size="4" name="language[]">
					@foreach($data['language'] as $language)
						<option value="{{$language->id}}"
							{{(is_array(old('language',$data['productlanguagearray'])) && in_array($language->id,old('language',$data['productlanguagearray'])) ) ? 'selected':''}}
							>{{__('messages.'.$language->name)}}							
						</option>
							
					@endforeach
				</select>
				@error('language')
                    <span class="invalid-feedback" role="alert" style="display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

				{{--
				@php $i=0; @endphp
				@foreach($data['language'] as $language)
					<div class="form-check form-check-inline">
						<input id="lang{{$i}}" type="checkbox" class="form-check-input" name="language[]"

						>
						<label for="lang{{$i}}" class="form-check-label">{{__('messages.'.$language->name)}}</label>
					</div>
					@php $i++; @endphp
				@endforeach
				--}}
			</div>
			<div class="">
				<h5><label>{{__('messages.producttag')}}</label></h5>
				@foreach($data['subcategory'] as $subcategory)
					<div class="col-4 float-left" style="overflow: hidden;white-space: nowrap;">
						<input id="prodsubcat{{$subcategory->id}}" type="checkbox" name="subcategory[]" value="{{$subcategory->id}}" 
						{{(is_array(old('subcategory',$data['productsubcategoryarray'])) && in_array($subcategory->id,old('subcategory',$data['productsubcategoryarray'])) ) ? 'checked':''}}>
						<label for="prodsubcat{{$subcategory->id}}">{{__('messages.'.$subcategory->name)}}</label>
					</div>
				@endforeach				
				@error('subcategory')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            @enderror
			</div>
			@php
				$title=$data['product']->title;
				$tc=0;
				$onelinesummary=$data['product']->onelinesummary;
				$oc=0;
				$introduction=$data['product']->introduction;
				$ic=0;

				$confirmlog=$data['product']->confirmlog->whereNull('confirmbyuserid')->first();
				if($confirmlog!=NULL){
					if($confirmlog->title!=NULL){
						$title=$confirmlog->title;
						$tc=1;
					}
					if($confirmlog->onelinesummary!=NULL){
						$onelinesummary=$confirmlog->onelinesummary;
						$oc=1;
					}
					if($confirmlog->introduction!=NULL){
						$introduction=$confirmlog->introduction;
						$ic=1;
					}
				}
			@endphp
			<div class="containerdivNewLine">
				<div class="form-group" >					
					<h5><label for="title">{{__('messages.traveltitle')}}</label></h5>
					<input type="text" class="form-control  @error('title') is-invalid @enderror" name="title" id="title" value="{{old('title',$title)}}">
					@if($tc)
						<span class="mt-2 bg-warning p-1">
							{{__('messages.awaitingadminapproval')}}
						</span>
					@endif
					@error('title')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            	@enderror
				</div>

				<div class="form-group">
					<h5><label for="onelinesummary">{{__('messages.onelinesummary')}}</label></h5>
					<input type="text" class="form-control  @error('onelinesummary') is-invalid @enderror" name="onelinesummary" value="{{old('onelinesummary',$onelinesummary)}}">
					@if($oc)
					<span class="mt-2 bg-warning p-1">
						{{__('messages.awaitingadminapproval')}}
					</span>
					@endif
					@error('onelinesummary')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            	@enderror
				</div>
				<div class="form-group">
					<h5><label for="travelintroduction">{{__('messages.travelintroduction')}}</label></h5>
					<textarea name="travelintroduction" class="form-control  @error('travelintroduction') is-invalid @enderror">{{old('travelintroduction',$introduction)}}</textarea>
					@if($ic)
					<span class="mt-2 bg-warning p-1">
						{{__('messages.awaitingadminapproval')}}
					</span>
					@endif
					@error('travelintroduction')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            	@enderror
				</div>
				<div>
					<div class="col-lg-6 float-left">
						<label>{{__('messages.travelsize')}}</label>
						<select id="toursize" class="form-control  @error('toursize') is-invalid @enderror" name="toursize"onchange="minimumnumber(this)">
							<option value=""></option>
							@foreach($data['toursize'] as $toursize)				
								<option value="{{$toursize->id}}" {{old('toursize',$data['product']->toursizeid)==$toursize->id ? 'selected':''}}>{{__('messages.'.$toursize->name)}}</option>
							@endforeach
						</select>
						@error('toursize')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            		@enderror
					</div>
					<div class="col-lg-6 float-left">
						<label>{{__('messages.vehicle')}}</label>
						<select class="form-control  @error('vehicle') is-invalid @enderror" name="vehicle" >
							@foreach($data['vehicle'] as $vehicle)
								<option value="{{$vehicle->id}}" {{old('vehicle',$data['product']->vehicleid)==$vehicle->id ? 'selected':''}}>{{__('messages.'.$vehicle->name)}}</option>
							@endforeach
						</select>
						@error('vehicle')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            		@enderror
	            		<div id="minimumnumberofdepartures" style="display: {{old('minimumnumberofdepartures',$data['product']->minimumnumberofdepartures)==NULL ? 'none':'block'}};">
	            			<label>{{__('messages.minimumnumberofdepartures')}}</label>
	            			<input class="form-control @error('minimumnumberofdepartures') is-invalid @enderror" type="number" name="minimumnumberofdepartures" value="{{old('minimumnumberofdepartures',$data['product']->minimumnumberofdepartures)}}" min="0"> 
	            			@error('minimumnumberofdepartures')
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
		            		@enderror
	            		</div>
					</div>
				</div>
				<div>
				</div>
				<label >{{__('messages.photo')}}</label>
				<br>
				<div class="col-12 col-lg-12" style="float: left;">
					@foreach($data['product']->photo as $row)
				     <div class="col-md-6 col-lg-4 mb-4" style="margin: 0px;float: left; height: 120px;">
			             <div class="property-entry h-100">	
					     	<div class="offer-type-wrap">       
					     		<span id="{{$row->photo->id}}" class="offer-type bg-danger" style="display: none;">{{__('messages.delete')}}</span>					     		
					     	</div>
					       	<img src="{{$row->photo->folder}}/{{$row->photo->name}}" alt="Image" class="img-fluid" style="max-width: 120px; max-height: 120px;" onclick="mydelete({{$row->photo->id}})">
					       	<input type="checkbox" id="d{{$row->photo->id}}" name="d{{$row->photo->id}}">
					     </div>       
					 </div>
		                    
		            @endforeach			            
		        </div>
		        <br>
		        <br>
				<div class="float-left">
					<div class="form-group col-12">
<!--						<label >{{__('messages.photo')}}</label>-->
						<input type="file" name="photos[]" class="form-control  @error('photos') is-invalid @enderror" multiple>
						<small id="emailHelp" class="form-text text-muted"></small>
						@error('photos')
		                    <span class="invalid-feedback" role="alert" style="display: block;">
		                        <strong>{{ $message }}</strong>
		                    </span>
	            		@enderror

	            		@error('photos.*')
						    <div class="alert alert-danger">{{ $message }}</div>
						@enderror

					</div>
					<div class="form-check">
						<input type="checkbox" name="havephotorights" class="form-check-input  @error('havephotorights') is-invalid @enderror" required>
						<label class="form-check-label">{{__('messages.wehaveconfirmedregisteredphotos')}}</label>
						@error('havephotorights')
		                    <span class="invalid-feedback" role="alert" style="display: block;">
		                        <strong>{{ $message }}</strong>
		                    </span>
	            		@enderror
					</div>
				</div>
			</div>

			<input type="submit" class="btn btn-primary" name="submit" value="{{__('messages.saveandnext')}}">
			</form>
		</div>
</div>
@endsection