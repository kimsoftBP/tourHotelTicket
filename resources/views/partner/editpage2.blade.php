@extends('partner.view')
@section('subincludecontent')
<script type="text/javascript">
	/*$( document ).ready(function() {
		getCity();
	});*/
</script>
<script type="text/javascript">
		function addtourcourse(){
			$("#tourcourses").append('<div class="form-group border" style="padding: 10px;">							<button type="button" class="btn btn-danger float-right" onclick="rmparent(this)">X</button>							<label>{{__('messages.tourtitle')}}</label>													<input class="form-control " type="text" name="tcoursetitle[]" >														<label>{{__('messages.timerequired')}}</label>							<div>								<div class="col-lg-6 float-left">									<label>{{__('messages.hour')}}</label>									<input class="form-control  type="number" min="0" name="tcoursehour[]" >																	</div>								<div class="col-lg-6 float-left">									<label>{{__('messages.minute')}}</label>									<input class="form-control  type="number" min="0" max="60" name="tcourseminute[]" >																	</div>							</div>							<label>{{__('messages.content')}}</label>							<textarea class="form-control"  name="tcoursecontent[]"></textarea>								            									<label>{{__('messages.photo')}}</label>							<input class="form-control"  type="file" name="tourcoursephoto[]">													</div>');
		}
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
		function addhours(){
			$("#hours").append('<div class="col-6 col-sm-4 col-md-3 col-lg-3 row pl-4">																		<button type="button" class="btn btn-sm btn-danger" onclick="rmparent(this)">X</button>									 	<input type="time" name="hours[]" class="form-control col-10">									</div>								');
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

	<div class="col-12 col-lg-9 col-xl-9 p-0">
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

		{{--
		@if($errors->any())
	<div class="alert text-danger">
		{{ implode('', $errors->all(':message')) }}
	</div>
@endif
--}}
		<div style="margin-bottom: 20px;">
			<!--
			<div class="">
				<a href="" class="pnum">1</a>
			</div>-->
			

			<div class="pearls row" data-by-row="true" data-plugin="matchHeight" role="tablist">
				<div class="col-4 col-xs-4 current pearl" data-target="#step1" role="tab" style="">
					<a class="pearl-number" href="{{route('partner.product.editpage1',['locale'=>app()->getLocale(),'product'=>$data['product']->id] )}}">1</a>
					<span class="pearl-title">
					<a href="{{route('partner.product.editpage1',['locale'=>app()->getLocale(),'product'=>$data['product']->id] )}}">{{__('messages.basicinformation')}}</a>
					</span>
				</div>
				<div class="col-4 col-xs-4 current pearl" data-target="#step2" role="tab">
					<span class="pearl-number">2</span>
					
					<span class="pearl-title">
					<a href="/partner/offers/103831/edit?step=2">{{__('messages.courseinformation')}}</a>
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

		<form action="{{ route('partner.product.editpage2', app()->getLocale()) }}" method="post" enctype="multipart/form-data" >

			@csrf
			<input type="hidden" name="product" value="{{$data['product']->id}}">

			@php
				$meetingplacename=$data['product']->meetingplacename;
				$mpc=0;
				$meetingplacecoordinate=$data['product']->meetingplacecoordinate;
				$mcc=0;
				$confirmlog=$data['product']->confirmlog->whereNull('confirmbyuserid')->first();
				if($confirmlog!=NULL){
					if($confirmlog->meetingplacename!=NULL){
						$meetingplacename=$confirmlog->meetingplacename;
						$mpc=1;
					}					
					if($confirmlog->meetingplacecoordinate!=NULL){
						$meetingplacecoordinate=$confirmlog->meetingplacecoordinate;
						$mcc=1;
					}
				}
			@endphp
			@php
				$days=[
					1=>'monday',
					2=>'tuesday',
					3=>'wednesday',
					4=>'thursday',
					5=>'friday',
					6=>'saturday',
					7=>'sunday',
						];

				$available=$data['product']->availableUi->first();
			@endphp
			<div><!-- page2 -->
				<div class="border p-2">
					<span></span>
					<div class="row m-0">
						<div class="form-group">
							<label class="h6">{{__('messages.fromdate')}}</label>
							<input type="date" name="FromDate" class="form-control @error('FromDate') is-invalid @enderror" value="{{old('FromDate',$available->from_date??'')}}">
							@error('FromDate')
								<div class="text-danger">{{$message}}</div>
							@enderror
						</div>
						<div class="form-group">
							<label class="h6">{{__('messages.todate')}}</label>
							<input type="date" name="ToDate" class="form-control @error('ToDate') is-invalid @enderror" value="{{old('ToDate',$available->to_date??'')}}">
							@error('ToDate')
								<div class="text-danger">{{$message}}</div>
							@enderror
						</div>
					</div>
					<div class="pl-3">
						@for($i=1;$i<=7;$i++)
							<span>
								<input id="w{{$i}}" type="checkbox" name="days[{{$i}}]" class="form-check-input" value="1" {{$available[$days[$i]]??''==1 ? 'checked':''}}>
								<label for="w{{$i}}" class="pr-4">{{__('messages.w'.$i)}}</label>
							</span>
						@endfor
					</div>
					<div id="">
						<div>
							<span class="h6">{{__('messages.hours')}}</span>
							<button type="button" class="btn btn-sm btn-primary" onclick="addhours()">+</button>
						</div>
						<div class="row m-2" id="hours">
							{{--@for($k=0;$k<3;$k++)--}}
							@php
								$h_array=[];
								if($available!=NULL){
									$h_array=json_decode($available->hour,true);
								}
								$c=count($h_array);
							@endphp
							@foreach($h_array as $row)
									<div class="col-6 col-sm-4 col-md-3 col-lg-3 row pl-4">								
										<button type="button" class="btn btn-sm btn-danger" onclick="rmparent(this)">X</button>
									 	<input type="time" name="hours[]" class="form-control col-10" value="{{$row}}">
									</div>								
							@endforeach
							@if($c==0)
								<div class="col-6 col-sm-4 col-md-3 col-lg-3 row pl-4">								
										<button type="button" class="btn btn-sm btn-danger" onclick="rmparent(this)">X</button>
									 	<input type="time" name="hours[]" class="form-control col-10" >
								</div>								
							@endif
						</div>
					</div>
				</div>

				<br>
				<div class="input-group">
					<div class="input-group-prepend" style="margin-right:10px;">
						<label class="h5">{{__('messages.meetingtime')}}</label>
					</div>
					<input class="form-control col-lg-3 @error('meetingtime') is-invalid @enderror" type="time" name="meetingtime" value="{{old('meetingtime',$data['product']->meetingtime)}}">			
					@error('meetingtime')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>
				<div>
					<label class="h5">{{__('messages.nameofmeetingplace')}}</label>
					<input type="text" class="form-control @error('nameofmeetingplace') is-invalid @enderror" name="nameofmeetingplace" value="{{old('nameofmeetingplace',$meetingplacename)}}">
					@if($mpc)
						<span class="mt-2 bg-warning p-1">
							{{__('messages.awaitingadminapproval')}}
						</span> 
					@endif
					@error('nameofmeetingplace')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>
				<div>
					<label class="h5">{{__('messages.meetingplacelocation')}}</label>
					<input type="text" class="form-control @error('meetingplacelocation') is-invalid @enderror" name="meetingplacelocation" value="{{old('meetingplacelocation',$meetingplacecoordinate)}}">
					@if($mcc)
						<span class="mt-2 bg-warning p-1">
							{{__('messages.awaitingadminapproval')}}
						</span>
					@endif
					@error('meetingplacelocation')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>


				<label class="h5">{{__('messages.meetingplacephoto')}}</label>
				<span>{{__('messages.onephotopossible')}}</span>
				<div class="col-12 col-lg-12" style="">
					@foreach($data['product']->meetingphoto as $row)
				     <div class="col-md-6 col-lg-4 mb-4" style="margin: 0px;float: left;">
			             <div class="property-entry h-100">	
					     	<div class="offer-type-wrap">       
					     		<span id="{{$row->photo->id}}" class="offer-type bg-danger" style="display: none;">{{__('messages.delete')}}</span>					     		
					     	</div>
					       	<img src="{{$row->photo->folder}}/{{$row->photo->name}}" alt="Image" class="img-fluid" style="max-width: 120px ; max-height: 120px;" onclick="mydelete({{$row->photo->id}})">
					       	<input type="checkbox" id="d{{$row->photo->id}}" name="d{{$row->photo->id}}">
					     </div>       
					 </div>
		                    
		            @endforeach			            
		        </div>
				<div>
					
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
						$k=0;
						$temp=$data['product']->tourcourse;
						if(old('tcoursetitle' ,$data['product']->tourcourse )!=NULL){
							$k=count(old('tcoursetitle',$data['product']->tourcourse ));
						}						
						//$k=2;
					@endphp
					<div id="tourcourses">
					@for($i=0;$i<$k;$i++)					
						@php
							$temptitle="";
							$wtconf=0;
							$temphour="";
							$tempminute="";
							$tempcontent="";
							$wcconf=0;
							$tempid="";
							if(isset($temp[$i])){
								$temptitle=$temp[$i]->title;
								$temphour=$temp[$i]->hour;
								$tempminute=$temp[$i]->minute;
								$tempcontent=$temp[$i]->content;
								if((old('tcoursetitle'))==NULL){
									$tempid=$temp[$i]->id;
								}
								if(isset($temp[$i]->log)){
									$v=$temp[$i]->log->whereNull('confirmbyuserid')->first();
									if($v!=NULL){
										if($v->title!=NULL){
											$temptitle=$v->title;
											$wtconf=1;
										}
										if($v->content!=NULL){										
											$tempcontent=$v->content;
											$wcconf=1;
										}
									}
								}
							}							
						@endphp
						<div class="form-group border" style="padding: 10px;">
							<button type="button" class="btn btn-danger float-right" onclick="rmparent(this)">X</button>
							<label>{{__('messages.tourtitle')}}</label>
							<input type="hidden" name="tcourseid[{{$i}}]" value="{{old('tcourseid.'.$i,$tempid)}}">
							<input class="form-control {!! $errors->has('tcoursetitle.'.$i) ? ' is-invalid' : '' !!}" type="text" name="tcoursetitle[]" value="{{old('tcoursetitle.'.$i,$temptitle)}}">
							@if($wtconf)
								<span class="mt-2 bg-warning p-1">{{__('messages.awaitingadminapproval')}}
								</span><br>
							@endif
							@error('tcoursetitle.'.$i)
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
			               	@enderror

							<label>{{__('messages.timerequired')}}</label>
							<div>
								<div class="col-lg-6 float-left">
									<label>{{__('messages.hour')}}</label>
									<input class="form-control {!! $errors->has('tcoursehour.'.$i) ? ' is-invalid' : '' !!}" type="number" min="0" name="tcoursehour[]" value="{{old('tcoursehour.'.$i,$temphour)}}">
									@error('tcoursehour.'.$i)
			                    		<span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
					               	@enderror
								</div>
								<div class="col-lg-6 float-left">
									<label>{{__('messages.minute')}}</label>
									<input class="form-control {!! $errors->has('tcourseminute.'.$i) ? ' is-invalid' : '' !!}" type="number" min="0" max="60" name="tcourseminute[]" value="{{old('tcourseminute.'.$i,$tempminute)}}">
									@error('tcourseminute.'.$i)
			                    		<span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
					               	@enderror
								</div>
							</div>

							<label>{{__('messages.content')}}</label>
							<textarea class="form-control {!! $errors->has('tcoursecontent.'.$i) ? ' is-invalid' : '' !!}" name="tcoursecontent[]">{{old('tcoursecontent.'.$i,$tempcontent)}}</textarea>
							@if($wcconf)
								<span class="mt-2 bg-warning p-1">{{__('messages.awaitingadminapproval')}}
								</span><br>
							@endif
							@error('tcoursecontent.'.$i)
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
			               	@enderror
		            		

							<label>{{__('messages.photo')}}</label>
							
							@if(isset($temp[$i]) && isset($temp[$i]->photo) && $temp[$i]->photo!=NULL)			
								@foreach($temp[$i]->photo as $row)					
								    <div class="col-md-6 col-lg-4 mb-4" style="margin: 0px;">
							            <div class="property-entry h-100">	
									     	<div class="offer-type-wrap">       
									     		<span id="{{$row->photo->id}}" class="offer-type bg-danger" style="display: none;">{{__('messages.delete')}}</span>					     		
									     	</div>
									       	<img src="{{$row->photo->folder}}/{{$row->photo->name}}" alt="Image" class="img-fluid" style="max-width: 120px ; max-height: 120px;" onclick="mydelete({{$row->photo->id}})">
									       	<input type="checkbox" id="d{{$row->photo->id}}" name="d{{$row->photo->id}}">
									    </div>       
									</div>
								@endforeach
						        
							@endif			
							
							<input class="form-control {!! $errors->has('photo.'.$i) ? ' is-invalid' : '' !!}" type="file" name="tourcoursephoto[]">
							@error('photo.'.$i)
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
			               	@enderror
						</div>
					@endfor
					</div>
					<button type="button" class="btn btn-info" onclick="addtourcourse()">+</button>
				</div>


				<div>
					<label class="h5">{{__('messages.totalrequiredtime')}}</label>
					<div>
						<div class="form-group float-left col-lg-4">
							<label>{{__('messages.day')}}</label>
							<input class="form-control" type="number" name="totalreqday" min="0" max="300" value="{{old('totalreqday',$data['product']->totalrequiredday)}}">
							@error('totalreqday')
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
		            		@enderror
		            	</div>

		            	<div class="form-group float-left col-lg-4">
		            		<label>{{__('messages.hour')}}</label>
							<input class="form-control" type="number" name="totalreqhour" min="0" max="24" value="{{old('totalreqhour',$data['product']->totalrequiredhour)}}">
							@error('totalreqhour')
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
		            		@enderror
		            	</div>
		            	<div class="form-group float-left col-lg-4">
		            		<label>{{__('messages.minute')}}</label>
							<input class="form-control" type="number" name="totalreqmin" min="0" max="60" value="{{old('totalreqmin',$data['product']->totalrequiredminute)}}">
							@error('totalreqmin')
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
		            		@enderror
	            		</div>
	            	</div>
				</div>
			</div>
			<input type="submit" class="btn btn-primary" name="submit" value="{{__('messages.saveandnext')}}">
			</form>
		</div>
</div>
@endsection