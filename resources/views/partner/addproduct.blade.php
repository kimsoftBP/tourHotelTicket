@extends('partner.view')
@section('subincludecontent')
<script type="text/javascript">
		function getCity() {
            $.ajax({
               type:'get',
               url:'/en/partner/city',
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

	<div class="col-lg-7 col-xl-7">
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
					<a class="pearl-number" href="">1</a>
					<span class="pearl-title">
					<a href="/partner/offers/103831/edit?step=1">{{__('messages.basicinformation')}}</a>
					</span>
				</div>
				<div class="col-4 col-xs-4  pearl" data-target="#step2" role="tab">
					<a class="pearl-number" href="">2</a>
					<!--
					<span class="pearl-title">
					<a href="/partner/offers/103831/edit?step=2">코스정보</a>
					</span>-->
				</div>
				<div class="col-4 col-xs-4 pearl" data-target="#step3" role="tab">
					<a class="pearl-number" href="">3</a>
					<!--
					<span class="pearl-title">
					<a href="/partner/offers/103831/edit?step=3">가격정보</a>
					</span>-->
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

		<form action="{{ route('partner.product.add', app()->getLocale()) }}" method="post" enctype="multipart/form-data" >

				@csrf

			<div class="form-group">
			    <h5><label for="">{{__('messages.country/city')}}</label></h5>
			    <div class="input-group">
			    	<div class="form-group col-lg-6">
					    <select class="form-control  @error('country') is-invalid @enderror" style="margin-right: 20px;" onchange="getCity()" id="country" name="country">
					    	<option value=""></option>
					    	 @foreach($data['country'] as $country)
					    	 	<option value="{{$country->name}}" {{old('country')==$country->name ? 'selected':''}}>{{__('messages.'.$country->name)}}</option>
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
			    	<input type="checkbox" class="form-check-input  @error('nocity') is-invalid @enderror" id="nocity" name="nocity" {{old('nocity')==true ? 'checked':''}}>
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
				
				@php $i=0; @endphp
				@foreach($data['category'] as $category)
					<div class="form-check form-check-inline fdorm-group">
						<input class="form-check-input" type="radio" name="category" value="{{$category->name}}" id="category{{$i}}" {{old('category')==$category->name ? 'checked':''}} >
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
							{{(is_array(old('language')) && in_array($language->id,old('language')) ) ? 'selected':''}}
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
						<input type="checkbox" name="subcategory[]" value="{{$subcategory->id}}">
						<label>{{$subcategory->name}}</label>
					</div>
				@endforeach				
				@error('subcategory')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            @enderror
			</div>
			
			<div class="containerdivNewLine">
				<div class="form-group" >
					<h5><label for="title">{{__('messages.traveltitle')}}</label></h5>
					<input type="text" class="form-control  @error('title') is-invalid @enderror" name="title" id="title" value="{{old('title')}}">
					@error('title')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            	@enderror
				</div>

				<div class="form-group">
					<h5><label for="onelinesummary">{{__('messages.onelinesummary')}}</label></h5>
					<input type="text" class="form-control  @error('onelinesummary') is-invalid @enderror" name="onelinesummary" value="{{old('onelinesummary')}}">
					@error('onelinesummary')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            	@enderror
				</div>
				<div class="form-group">
					<h5><label for="travelintroduction">{{__('messages.travelintroduction')}}</label></h5>
					<textarea name="travelintroduction" class="form-control  @error('travelintroduction') is-invalid @enderror">{{old('travelintroduction')}}</textarea>
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
								<option value="{{$toursize->id}}" {{old('toursize')==$toursize->id ? 'selected':''}}>{{__('messages.'.$toursize->name)}}</option>
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
								<option value="{{$vehicle->id}}">{{__('messages.'.$vehicle->name)}}</option>
							@endforeach
						</select>
						@error('vehicle')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
	            		@enderror
	            		<div id="minimumnumberofdepartures" style="display: {{old('minimumnumberofdepartures')==NULL ? 'none':'block'}};">
	            			<label>{{__('messages.minimumnumberofdepartures')}}</label>
	            			<input class="form-control @error('minimumnumberofdepartures') is-invalid @enderror" type="number" name="minimumnumberofdepartures" value="{{old('minimumnumberofdepartures')}}" min="0"> 
	            			@error('minimumnumberofdepartures')
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
		            		@enderror
	            		</div>
					</div>
				</div>

				<div>
					<div class="form-group">
						<label >{{__('messages.photo')}}</label>
						<input type="file" name="photo[]" class="form-control  @error('photo') is-invalid @enderror" multiple>
						<small id="emailHelp" class="form-text text-muted"></small>
						@error('photo')
		                    <span class="invalid-feedback" role="alert" style="display: block;">
		                        <strong>{{ $message }}</strong>
		                    </span>
	            		@enderror
					</div>
					<div class="form-check">
						<input type="checkbox" name="havephotorights" class="form-check-input  @error('havephotorights') is-invalid @enderror" >
						<label class="form-check-label">{{__('messages.wehaveconfirmedregisteredphotos')}}</label>
						@error('havephotorights')
		                    <span class="invalid-feedback" role="alert" style="display: block;">
		                        <strong>{{ $message }}</strong>
		                    </span>
	            		@enderror
					</div>
				</div>
			</div>

			<div><!-- page2 -->
				<br>
				<div class="input-group">
					<div class="input-group-prepend" style="margin-right:10px;">
						<label>{{__('messages.meetingtime')}}</label>
					</div>
					<input class="form-control col-lg-3 @error('meetingtime') is-invalid @enderror" type="time" name="meetingtime" value="{{old('meetingtime')}}">

					@error('meetingtime')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>
				<div>
					<label>{{__('messages.nameofmeetingplace')}}</label>
					<input type="text" class="form-control @error('nameofmeetingplace') is-invalid @enderror" name="nameofmeetingplace" value="{{old('nameofmeetingplace')}}">
					@error('nameofmeetingplace')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>
				<div>
					<label>{{__('messages.meetingplacelocation')}}</label>
					<input type="text" class="form-control @error('meetingplacelocation') is-invalid @enderror" name="meetingplacelocation" value="{{old('meetingplacelocation')}}">
					@error('meetingplacelocation')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>
				<div>
					<label>{{__('messages.meetingplacephoto')}}</label>
					<input type="file" class="form-control @error('meetingplacephoto') is-invalid @enderror" name="meetingplacephoto">
					@error('meetingplacephoto')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>

				<div class="border" style="padding:20px;margin-top:20px;">
					<h5><span>{{__('messages.tourcourse')}}</span></h5>
					@php
						$k=1;
						if(old('tcoursetitle')!=NULL){
							$k=count(old('tcoursetitle'));
						}
					@endphp
					
					@for($i=0;$i<$k;$i++)
						<div class="form-group border" style="padding: 10px;">
							<button type="button" class="btn btn-danger float-right" onclick="rmparent(this)">X</button>
							<label>{{__('messages.tourtitle')}}</label>
							<input class="form-control {!! $errors->has('tcoursetitle.'.$i) ? ' is-invalid' : '' !!}" type="text" name="tcoursetitle[]">
							@error('tcoursetitle.'.$i)
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
			               	@enderror

							<label>{{__('messages.timerequired')}}</label>
							<div>
								<div class="col-lg-6 float-left">
									<label>{{__('messages.hour')}}</label>
									<input class="form-control {!! $errors->has('tcoursehour.'.$i) ? ' is-invalid' : '' !!}" type="number" min="0" name="tcoursehour[]">
									@error('tcoursehour.'.$i)
			                    		<span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
					               	@enderror
								</div>
								<div class="col-lg-6 float-left">
									<label>{{__('messages.minute')}}</label>
									<input class="form-control {!! $errors->has('tcourseminute.'.$i) ? ' is-invalid' : '' !!}" type="number" min="0" max="60" name="tcourseminute[]">
									@error('tcourseminute.'.$i)
			                    		<span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
					               	@enderror
								</div>
							</div>

							<label>{{__('messages.content')}}</label>
							<textarea class="form-control {!! $errors->has('tcoursecontent.'.$i) ? ' is-invalid' : '' !!}" name="tcoursecontent[]">{{old('tcoursecontent.'.$i)}}</textarea>
							@error('tcoursecontent.'.$i)
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
			               	@enderror
		            		

							<label>{{__('messages.photo')}}</label>
							<input class="form-control {!! $errors->has('photo.'.$i) ? ' is-invalid' : '' !!}" type="file" name="">
							@error('photo.'.$i)
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
			               	@enderror
						</div>
					@endfor

					<button type="button" class="btn btn-info">+</button>
				</div>


				<div>
					<label>{{__('messages.totalrequiredtime')}}</label>
					<div>
						<div class="form-group float-left col-lg-4">
							<label>{{__('messages.day')}}</label>
							<input class="form-control" type="number" name="totalreqday" min="0" max="300" value="{{old('totalreqday')}}">
							@error('totalreqday')
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
		            		@enderror
		            	</div>

		            	<div class="form-group float-left col-lg-4">
		            		<label>{{__('messages.hour')}}</label>
							<input class="form-control" type="number" name="totalreqhour" min="0" max="24" value="{{old('totalreqhour')}}">
							@error('totalreqhour')
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
		            		@enderror
		            	</div>
		            	<div class="form-group float-left col-lg-4">
		            		<label>{{__('messages.minute')}}</label>
							<input class="form-control" type="number" name="totalreqmin" min="0" max="60" value="{{old('totalreqmin')}}">
							@error('totalreqmin')
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
		            		@enderror
	            		</div>
	            	</div>
				</div>
			</div>
			<!--page3 -->
			<div>
				<div class="col-12">
					<label>{{__('messages.price')}}</label>

				</div>
				<br>
				<div>
					<label>{{__('messages.priceincluded')}}</label>
					<textarea name="priceincluded" class="form-control @error('priceincluded') is-invalid @enderror">{{old('priceincluded')}}</textarea>					
					@error('priceincluded')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>
				<div>
					<label>{{__('messages.pricenotincluded')}}</label>
					<textarea name="pricenotincluded" class="form-control @error('pricenotincluded') is-invalid @enderror">{{old('pricenotincluded')}}</textarea>					
					@error('pricenotincluded')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>
				<div>
					<label>{{__('messages.essentialguidance')}}</label>
					<textarea name="essentialguidance" class="form-control @error('essentialguidance') is-invalid @enderror">{{old('essentialguidance')}}</textarea>
					@error('essentialguidance')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
            	</div>


            	<div style="margin-top: 20px;">
            		<span>{{__('messages.Additional booking information')}}</span>
            		<div>
	            		<input type="checkbox" name=""><label>Hotel information</label>
	            		<input type="checkbox" name=""><label>Flight departure information</label>
	            		<input type="checkbox" name=""><label>Air arrival information</label>
	            	</div>
            	</div>
				<!-- 					
					hotel pickup option,,,,,



					tour coures
						-title
						-time
						-content
						-photo

					total time required
	
					price


					price included
					price not included

					esssential guidance

					additional booking information
						-do not select
						-representative tourist information
						-hotel information
						-air arrival information
						-usage time
						-flight departure information
				-->
			</div>
			{{--
				@error('continent')
                    <span class="invalid-feedback" role="alert" style="display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                    
                @enderror
            --}}

			<input type="submit" class="btn btn-primary" name="submit">
			</form>
		</div>
</div>
@endsection