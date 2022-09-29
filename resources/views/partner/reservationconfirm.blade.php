@extends('partner.view')
@section('subincludecontent')
<script type="text/javascript">
	function setresponse(argument) {
		$("#response").val(argument);
		console.log(argument);
	}
</script>
@endsection
@section('subcontent')
<div> 
	<form action="{{route('partner.reservation.postresponse' , app()->getLocale())}}" method="post">
		@php
			$cname="";
			if(($data['reservation']->cloneproduct->city)!=NULL){					
				$cityname=json_decode($data['reservation']->cloneproduct->city->namearray,true);
				$loc=$data['locale'];
				if(isset($cityname[$loc])){
					$cname=$cityname[$loc];
				}else{
					$cname=$data['product']->city->name;
				}
			}
		@endphp
		<div>
			{{$data['reservation']->cloneproduct->country->name}}/{{$cname}}

			<a href="{{route('offers.product',['locale'=>app()->getLocale(),'slug'=>$data['reservation']->cloneproduct->title]) }}" class="text-dark">
			<br><br><span>{{$data['reservation']->cloneproduct->title}}</span>
			</a>
		</div>

		<table class="table table-hover">
				<tr>
					<th></th>
					<th>{{__('messages.priceperperson')}}
					<th></th>
					<th></th>
				</tr>
				<tr>
					<td>{{$data['reservation']->date}}</td>
					<td>{{$data['reservation']->priceperperson}} {!! $data['reservation']->currency->html !!}</td>
					<td>{{$data['reservation']->person}}</td>
					<td>{{$data['reservation']->priceperperson*$data['reservation']->person}}  {!! $data['reservation']->currency->html !!}</td>
				</tr>
				<tr>
					<th colspan="4" style="text-align:left;">{{__('messages.ticket')}}</th>
				</tr>
				<tr>
					<th></th>
					<th>{{__('messages.price')}}</th>
					<th>{{__('messages.piece')}}</th>
					<th></th>
				</tr>
				@foreach($data['reservation']->ticket as $ticket)
					<tr>
						<td><h5>{{$ticket->title}}</h5>
								<span>{{$ticket->shortdesc}}</span>
						</td>
						<td>{{$ticket->price}} {!! $data['reservation']->currency->html !!}</td>
						<td>{{$ticket->piece}}</td>
						<td>{{$ticket->sumprice}} {!! $data['reservation']->currency->html !!}</td>
					</tr>
				@endforeach
				<tr>
					<th colspan="3" style="text-align:left;">{{__('messages.totalamount')}}</th>
					<td>{{$data['reservation']->sumprice}} {!! $data['reservation']->currency->html !!}</td>
				</tr>
			</table>
		
<!--
		<div class="form-check btn btn-success mt-5 pl-4">
		    <input type="radio" name="response" value="1" id="accept">
		    <label class="form-check-label" for="accept">Confirm</label>
		</div>
		<br>
		<div class="form-check btn btn-danger  pl-4">
		    <input type="radio" name="response" value="0" id="">
		    <label class="form-check-label" for=""></label>
		</div>
		<br>
-->
		<input type="hidden" name="reservation" value="{{$data['reservation']->id}}">
		<input type="hidden" name="response" id="response" value="">

		<button type="button" class="btn btn-success" onclick="setresponse(1)">Confrim</button>		
		<button type="button" class="btn btn-danger" onclick="setresponse(0)">Disclaim</button>
		<!-- disclaim lemond elutasit -->
	</form>
</div>

@endsection