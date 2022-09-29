@extends('partner.view')
@section('subincludecontent')
<script type="text/javascript">
	/*$( document ).ready(function() {
		getCity();
	});*/
</script>
<script type="text/javascript">
		function addprice(){
		$("#price").append('											<div class="input-group">								<label></label>								<div class="form-group col-4">									<label>{{__('messages.productperson')}}</label>									<input class="form-control " type="number" name="person[]" min="0">																	</div>								<div class="form-group col-7">									<label>{{__('messages.priceperperson')}}</label>									<input class="form-control"  type="number" name="price[]" min="0">																</div>								<div class="form-group col-1">									<div style="padding-top: 20px;">										<button type="button" class="btn btn-light border" onclick="rmparent2(this)">X</button>									</div>								</div>							</div>');
		}

		function addticket(){
			$("#ticket").append('							<div class="border mt-2"><div class="form-group col-12">			<div class="col-8 float-left">						<label>{{__('messages.title')}}</label>									<input class="form-control" type="text" name="tickettitle[]"></div>	<div class="col-1 float-right pt-2">				            			<button type="button" class="btn btn-light border" onclick="rmparent2(this)">X</button>				            		</div>																</div>																						<div class="form-group col-4 float-left" style="clear:both">									<label>{{__('messages.price')}}</label>									<input class="form-control" type="number" min="0" name="ticketprice[]">																	</div>							<!--	<div class="form-group col-4 float-left">									<label>{{__('messages.currency')}}</label>									<select class="form-control " name="ticketcurrency">											<option></option>											@foreach($data['currency'] as $currency)												<option value="{{$currency->id}}" >{!! $currency->html !!}</option>											@endforeach										</select>																	</div>	-->							<div class="form-group col-4 float-left">									<label>{{__('messages.valid')}}</label>									<input class="form-control" type="date" name="ticketvalid[]">																	</div>								<div class="form-group pl-3 pr-3" style="clear: both;">									<label>{{__('messages.shortdesc')}}</label>									<textarea class="form-control" name="ticketshortdesc[]"></textarea>																	</div>															<div style="clear: both;"></div>							</div>');
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
		function rmparent2(em){
        	$(em).parent().parent().parent().remove()
        	console.log("rm");
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

		function pricetype1(){
			$("#pricetype2").attr('checked', false);
			$("#pricetype1").attr('checked', true);
		}
		function pricetype2(){
			$("#pricetype1").attr('checked', false);
			$("#pricetype2").attr('checked', true);
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

	<div class="col-sm-12 col-md-12 col-lg-9 col-xl-9" style="">
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
					<a class="pearl-number" href="{{route('partner.product.editpage2',['locale'=>app()->getLocale(),'product'=>$data['product']->id] )}}">2</a>
					
					<span class="pearl-title">
					<a  href="{{route('partner.product.editpage2',['locale'=>app()->getLocale(),'product'=>$data['product']->id] )}}">{{__('messages.courseinformation')}}</a>
					</span>
				</div>
				<div class="col-4 col-xs-4 current pearl" data-target="#step3" role="tab">
					<span class="pearl-number" href="">3</span>
					
					<span class="pearl-title">
					<a href="#">{{__('messages.priceinformation')}}</a>
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

		<form action="{{ route('partner.product.editpage3', app()->getLocale()) }}" method="post" enctype="multipart/form-data" >

			@csrf

			<input type="hidden" name="product" value="{{$data['product']->id}}">
			<!--page3 -->




			@php
				$datapricetype="";
				if(isset($data['product']->pricetype) &&$data['product']->pricetype->name!=NULL){
					$datapricetype=$data['product']->pricetype->name;
				}
			@endphp
			<div>				
				<div class="col-12" style="padding: 0px;padding-top: 00px;">
					<label>{{__('messages.price')}}</label>
					@error('pricetype')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
            		@php
            			$simpleprice=$data['product']->price->where('notes','simple')->first();
            			$simplemin="";
            			$simplemax="";
            			$simplecurrency=NULL;
            			$simpleamount="";
            			if(isset($simpleprice->minimumpeople)){
							$simplemin=$simpleprice->minimumpeople;
						}
						if(isset($simpleprice->maximumpeople)){
							$simplemax=$simpleprice->maximumpeople;
						}
						if(isset($simpleprice->currencyid)){
							$simplecurrency=$simpleprice->currencyid;
						}
						if(isset($simpleprice->amount)){
							$simpleamount=$simpleprice->amount;
						}
						$anyprice=$data['product']->price->first();
						if(isset($anyprice->currencyid)){
							$simplecurrency=$anyprice->currencyid;
						}
            		@endphp
					<div class="input-group col-lg-3 pb-2">
						<label>{{__('messages.currency')}}</label>
						<select class="form-control @error('currency') is-invalid @enderror" name="currency">
							<option></option>
							@foreach($data['currency'] as $currency)
								<option value="{{$currency->id}}" {{$currency->id==old('currency',$simplecurrency) ? 'selected':''}}>{!! $currency->html !!}</option>
							@endforeach
						</select>
						@error('currency')
		                    <span class="invalid-feedback" role="alert" style="display: block;">
		                        <strong>{{ $message }}</strong>
		                    </span>
	            		@enderror
					</div>
					<div>
						<div class="col-1 float-left" style="padding-top: 10px padding-bottom :10px; ">
							<input type="radio" id="pricetype1" name="pricetype" value="simple" {{old('pricetype',$datapricetype)=="simple" ? 'checked':''}}>
						</div>
						<div class=" border col-md-12 col-sm-12 col-lg-11 float-left" style="margin:0px;padding: 0px;" onclick="pricetype1()">
							<div class="col-12" style="padding: 10px;background-color: #DDF0F3;margin: 0px;">
								<span>{{__('messages.simplepricing')}}</span>
							</div>
							<div class="input-group mb-3">
								<div class="form-group col-sm-4 col-md-4 col-lg-2">
									<label>{{__('messages.minimumpeople')}}</label>
									<input class="form-control @error('minimum') is-invalid @enderror" type="number" name="minimum" value="{{old('minimum',$simplemin)}}" min="0">
									@error('minimum')
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
								<div class="form-group col-lg-3">
									<label>{{__('messages.maximumpeople')}}</label>
									<input class="form-control @error('maximum') is-invalid @enderror" type="number" name="maximum" min="0" value="{{old('maximum',$simplemax)}}">
									@error('maximum')
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
							
								<div class="form-group col-lg-4">
									<label>{{__('messages.priceperperson')}}</label>
									<input class="form-control @error('amount') is-invalid @enderror" type="number" name="amount"step=1 min="0" value="{{old('amount',$simpleamount)}}">
									@error('amount')
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
							</div>
						</div>
					</div>
					<div class="col-12" style="padding: 0px;margin-top:30px;">
						<div class="col-1 float-left">
							<input type="radio" id="pricetype2" name="pricetype" value="priceperperson" {{old('pricetype',$datapricetype)=="priceperperson" ? 'checked':''}}>
						</div>
						<div class="border col-sm-12 col-md-12 col-lg-11 float-left" style="padding: 0px;" onclick="pricetype2()">
							<div id="price">
							@php
								$k=1;
								$temp=$data['product']->price;
								if((old('person',$temp))!=NULL){
									$k=count(old('person',$temp));
								}
								$price=$data['product']->price->where('notes','!=','simple')->first();
								$pcurrency="";
								if(isset($price)){
									$pcurrency=$price->currencyid;
								}
							@endphp							
							
							<div class="col-12" style="padding: 10px;background-color: #DDF0F3;margin: 0px;">
								<span>{{__('messages.pricesettingperperson')}}</span>
							</div>
							<!--
							<div class="form-group col-lg-3 ">
									<label>{{__('messages.currency')}}</label>
									<select class="form-control @error('currencyper') is-invalid @enderror" name="currencyper">
										<option></option>
										@foreach($data['currency'] as $currency)
											<option value="{{$currency->id}}" {{$currency->id==old('currencyper',$pcurrency) ? 'selected':''}}>{!! $currency->html !!}</option>
										@endforeach
									</select>
									@error('currencyper')
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
							</div>-->

							@for($i=0;$i<$k;$i++)
								@php
									$pricerowid=NULL;
									$person=NULL;
									$price=NULL;
									if(isset($temp[$i])){
										$pricerowid=$temp[$i]->id;
										$person=$temp[$i]->person;
										$price=$temp[$i]->amount;
									}
								@endphp
							<div class="input-group border">
								<label></label>
								
								<input type="hidden" name="priceperid[]" value="{{$pricerowid}}">
								
								<div class="form-group col-4">
									<label>{{__('messages.productperson')}}</label>
									<input class="form-control @error('person.'.$i) is-invalid @enderror" type="number" name="person[]" min="0" value="{{old('person.'.$i,$person)}}">
									@error('person.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
								<div class="form-group col-sm-6 col-md-6 col-lg-7">
									<label>{{__('messages.priceperperson')}}</label>
									<input class="form-control @error('price.'.$i) is-invalid @enderror" type="number" name="price[]" min="0" value="{{old('price.'.$i,$price)}}">
									@error('price.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
								<div class="form-group col-1">
									<div style="padding-top: 20px;">
										<button type="button" class="btn btn-light border" onclick="rmparent2(this)">X</button>
									</div>
								</div>
							</div>
							@endfor
							</div>
							<div style="margin: 10px;">
								<button type="button" class="btn btn-light border" onclick="addprice()">+ {{__('messages.addingmorepeople')}}</button>
							</div>
						</div>
					</div>
				</div>
				<div style="clear: both;"></div>


				<!--{{-- ticket START--}}-->


				<div class="border mt-2 p-2">
					<div class="col-12 m-2 p-0" style="4background-color: #DDF0F3">{{__('messages.editpageticket')}}</div>
					<div id="ticket" class="pb-3">
						<div class="form-check float-left">
						@php
							$eticket="";
							if( $data['product']->ticket->first()!=NULL ){
								$e=$data['product']->ticket->first();
								$eticket=$e->eticket;						
							}
							$ticketcurrency="";
							if($data['product']->ticket->first()!=NULL){
								$ticketcurrency=$data['product']->ticket->first()->currencyid;
							}
						@endphp
								<input id="eticket" class="form-check-input" type="checkbox" name="eticket" {{old('eticket',$eticket) ? 'checked':''}} value="1">
								<label for="eticket" class="form-check-label">{{__('messages.eticket')}}</label>
						</div>
						<!--
						<div class="form-group col-4 float-left">
							<label>{{__('messages.currency')}}</label>
							<select class="form-control @error('ticketcurrency') is-invalid @enderror" name="ticketcurrency" >
									<option></option>
									@foreach($data['currency'] as $currency)
										<option value="{{$currency->id}}" {{$currency->id==old('ticketcurrency',$ticketcurrency) ? 'selected':''}}>{!! $currency->html !!}</option>
									@endforeach
								</select>
							@error('ticketcurrency')
			                    <span class="invalid-feedback" role="alert" style="display: block;">
			                        <strong>{{ $message }}</strong>
			                    </span>
		            		@enderror
						</div>
					-->
						<div style="clear: both;"></div>
						@php
							$t=0;
							$tempticket=$data['product']->ticket;
							if((old('person',$tempticket))!=NULL){
								$t=count(old('tickettitle',$tempticket));
							}
							//$t=1;
							/*
							
							$price=$data['product']->price->where('notes','!=','simple')->first();
							$pcurrency="";
							if(isset($price)){
								$pcurrency=$price->currencyid;
							}
							*/
						@endphp	

						@for($i=0;$i<$t;$i++)
							@php
								$tickettitle=NULL;
								$tickettitlenotconf=0;
								$ticketprice=NULL;
								$ticketcurrency=NULL;
								$ticketvalid=NULL;
								$ticketshortdesc=NULL;
								$ticketshortdescnotconf=0;
								$ticketid=NULL;
								
								if(isset($tempticket[$i])){
									$tickettitle=$tempticket[$i]->title;
									$ticketprice=$tempticket[$i]->price;
									$ticketcurrency=$tempticket[$i]->currencyid;
									$ticketvalid=$tempticket[$i]->expire;
									$ticketshortdesc=$tempticket[$i]->shortdesc;
									$ticketid=$tempticket[$i]->id;

									/*
									$pricerowid=$temp[$i]->id;
									$person=$temp[$i]->person;
									$price=$temp[$i]->amount;
									*/ 

									$v=$data['product']->ticket->where('id',$ticketid)->first()->change->whereNull('confirmbyuserid')->first();
									if($v!=NULL){
										if($v->title!=NULL){										
											$tickettitle=$v->title;
											$tickettitlenotconf=1;
										}
										if($v->shortdesc!=NULL){
											$ticketshortdesc=$v->shortdesc;
											$ticketshortdescnotconf=1;
										}
									}
									

								}
							@endphp
							<div class="border mt-2">
								<input type="hidden" name="ticketid[]" value="{{$ticketid}}">
								<div class="form-group col-12">
									<div class="col-8 float-left">
										<label>{{__('messages.title')}}</label>
										<input class="form-control @error('tickettitle.'.$i) is-invalid @enderror" type="text" name="tickettitle[]" value="{{old('tickettitle.'.$i,$tickettitle)}}">
										@if($tickettitlenotconf)
											<span class="mt-2 bg-warning p-1">{{__('messages.awaitingadminapproval')}}
											</span><br>
										@endif
										@error('tickettitle.'.$i)
						                    <span class="invalid-feedback" role="alert" style="display: block;">
						                        <strong>{{ $message }}</strong>
						                    </span>
					            		@enderror
				            		</div>
				            		<div class="col-1 float-right pt-2">
				            			<button type="button" class="btn btn-light border" onclick="rmparent2(this)">X</button>
				            		</div>
								</div>														
								<div class="form-group col-4 float-left" style="clear: both;">
									<label>{{__('messages.price')}}</label>
									<input class="form-control" type="number" min="0" name="ticketprice[]" value="{{old('ticketprice.'.$i,$ticketprice)}}">
									@error('ticketprice.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
								<!--{{--
								<div class="form-group col-4 float-left">
									<label>{{__('messages.currency')}}</label>
									<select class="form-control @error('ticketcurrency') is-invalid @enderror" name="ticketcurrency[]" >
											<option></option>
											@foreach($data['currency'] as $currency)
												<option value="{{$currency->id}}" {{$currency->id==old('ticketcurrency.'.$i,$ticketcurrency) ? 'selected':''}}>{!! $currency->html !!}</option>
											@endforeach
										</select>
									@error('ticketcurrency.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>--}}-->
								<div class="form-group col-4 float-left">
									<label>{{__('messages.valid')}}</label>
									<input class="form-control" type="date" name="ticketvalid[]" value="{{old('ticketvalid.'.$i,$ticketvalid)}}">
									@error('ticketvalid.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
								<div class="form-group pl-3 pr-3" style="clear: both;">
									<label>{{__('messages.shortdesc')}}</label>
									<textarea class="form-control" name="ticketshortdesc[]" >{{old('ticketshortdesc.'.$i,$ticketshortdesc)}}</textarea>
									@if($ticketshortdescnotconf)
										<span class="mt-2 bg-warning p-1">{{__('messages.awaitingadminapproval')}}
										</span><br>
									@endif
									@error('ticketshortdesc.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>							
								<div class="pl-3 pr-3 ">
									<label>{{__('messages.piece')}}</label>
									<div class="row">
										@php
											$m=0;
										@endphp
										@foreach($data['product']->availableAfterToday as $available_row)
											<div class="form-group row col-12 col-md-6">
												<label class="col-form-label">{{$available_row->date}} {{$available_row->hour}}</label>
												<input type="hidden" name="available[{{$m}}][ticket]" value="{{$tempticket[$i]->id}}">
												<input type="hidden" name="available[{{$m}}][date]" value="{{$available_row->date}}">
												<input type="hidden" name="available[{{$m}}][hour]" value="{{$available_row->hour}}">
												<div class="col-4 col-md-4">
													<input type="number" name="available[{{$m}}][piece]" class="form-control" value="{{$tempticket[$i]->availableIn($available_row->date,$available_row->hour)}}">
												</div>
											</div>
											@php
												$m++;
											@endphp
										@endforeach
									</div>
								</div>
								<div style="clear: both;"></div>
							</div>
						@endfor
						<!--
							<div class="border mt-2">
								<div class="form-group col-12">
									<label>{{__('messages.title')}}</label>
									<input class="form-control" type="text" name="tickettitle[]">
									@error('tickettitle.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>														
								<div class="form-group col-4 float-left">
									<label>{{__('messages.price')}}</label>
									<input class="form-control" type="number" min="0" name="ticketprice[]">
									@error('ticketprice.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
								<div class="form-group col-4 float-left">
									<label>{{__('messages.currency')}}</label>
									<select class="form-control @error('ticketcurrency') is-invalid @enderror" name="ticketcurrency[]">
											<option></option>
											@foreach($data['currency'] as $currency)
												<option value="{{$currency->id}}" {{$currency->id==old('currencyper',$pcurrency) ? 'selected':''}}>{!! $currency->html !!}</option>
											@endforeach
										</select>
									@error('ticketcurrency.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
								<div class="form-group col-4 float-left">
									<label>{{__('messages.valid')}}</label>
									<input class="form-control" type="date" name="ticketvalid[]">
									@error('ticketvalid.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>
								<div class="form-group pl-3 pr-3" style="clear: both;">
									<label>{{__('messages.shortdesc')}}</label>
									<textarea class="form-control" name="ticketshortdesc[]"></textarea>
									@error('ticketshortdesc.'.$i)
					                    <span class="invalid-feedback" role="alert" style="display: block;">
					                        <strong>{{ $message }}</strong>
					                    </span>
				            		@enderror
								</div>							
								<div style="clear: both;"></div>
							</div>
						-->
					</div>
					<button type="button" class="btn btn-light border" onclick="addticket()">+</button>
				</div>

			@php
				$priceincluded=$data['product']->priceincluded;
				$pic=0;
				$notincluded=$data['product']->notincluded;
				$pnc=0;
				$essentialguidance=$data['product']->essentialguidance;
				$ec=0;

				

				$confirmlog=$data['product']->confirmlog->whereNull('confirmbyuserid')->first();
				if($confirmlog!=NULL){
					if($confirmlog->priceincluded!=NULL){
						$priceincluded=$confirmlog->priceincluded;
						$pic=1;
					}
					if($confirmlog->notincluded!=NULL){
						$notincluded=$confirmlog->notincluded;
						$pnc=1;
					}
					if($confirmlog->essentialguidance!=NULL){
						$essentialguidance=$confirmlog->essentialguidance;
						$ec=1;
					}
				}
			@endphp

				<!--{{-- ticket END--}}-->
				<br>
				<div>
					<label>{{__('messages.priceincluded')}}</label>
					<textarea name="priceincluded" class="form-control @error('priceincluded') is-invalid @enderror">{{old('priceincluded',$priceincluded)}}</textarea>					
					@if($pic)
						<span class="mt-2 bg-warning p-1">
							{{__('messages.awaitingadminapproval')}}
						</span>
					@endif
					@error('priceincluded')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>
				<div>
					<label>{{__('messages.pricenotincluded')}}</label>
					<textarea name="pricenotincluded" class="form-control @error('pricenotincluded') is-invalid @enderror">{{old('pricenotincluded',$notincluded)}}</textarea>			
					@if($pnc)
						<span class="mt-2 bg-warning p-1">
							{{__('messages.awaitingadminapproval')}}
						</span>
					@endif
					@error('pricenotincluded')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
				</div>
				<div>
					<label>{{__('messages.essentialguidance')}}</label>
					<textarea name="essentialguidance" class="form-control @error('essentialguidance') is-invalid @enderror">{{old('essentialguidance',$essentialguidance)}}</textarea>
					@if($ec)
						<span class="mt-2 bg-warning p-1">
							{{__('messages.awaitingadminapproval')}}
						</span>
					@endif
					@error('essentialguidance')
	                    <span class="invalid-feedback" role="alert" style="display: block;">
	                        <strong>{{ $message }}</strong>
	                    </span>
            		@enderror
            	</div>


            	<div style="margin-top: 20px;">
            		<span>{{__('messages.Additional booking information')}}</span>
            		<div>
	            		<br><input class="form-check-input" type="checkbox" name="additional[0]" value="hotel" id="additional1" 
	            		{{(old('additional.0')=='hotel' || (old('_token')==NULL && $data['product']->additionalhotel))? 'checked':''}}><label for="additional1" style="">{{__('messages.Hotel information')}}</label>
	            		<br><input class="form-check-input" type="checkbox" name="additional[1]" value="flightdeparture" id="additional2"
	            		{{(old('additional.1')=='flightdeparture' || (old('_token')==NULL && $data['product']->additionalflightdeparture))? 'checked':''}}><label for="additional2">{{__('messages.Flight departure information')}}</label>
	            		<br><input class="form-check-input" type="checkbox" name="additional[2]" value="airarrival" id="additional3"
	            		{{(old('additional.2')=='airarrival' || (old('_token')==NULL && $data['product']->additionalairarrival))? 'checked':''}}><label for="additional3">{{__('messages.Air arrival information')}}</label>
	            	</div>
            	</div>            	
            	{{--
				<!-- 					
	

					additional booking information
						-do not select
						-representative tourist information
						-hotel information
						-air arrival information
						-usage time
						-flight departure information
				-->
				--}}
			</div>
			
			<input type="submit" class="btn btn-primary" name="submit" value="{{__('messages.save')}}">
			</form>

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
		</div>
</div>
@endsection