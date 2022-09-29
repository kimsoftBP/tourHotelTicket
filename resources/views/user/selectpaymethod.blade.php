@extends('view')
@section('includecontent')

@endsection
@section('content')
<div class="col-10 col-md-8" style="margin:auto;">	
	<table class="table table-hover">
		@php
			$html=$data['reservation']->currency->html;
		@endphp
		<tr>
			<td>{{$data['reservation']->date}}</td>
			<td>{{$data['reservation']->person}}</td>
			<td class="text-right">{{$data['reservation']->priceperperson}} {!! $html !!}</td>
			<td class="text-right">{{$data['reservation']->person*$data['reservation']->priceperperson}} {!! $html !!}</td>
		</tr>
		@foreach($data['reservation']->ticket as $ticket)
			<tr>
				<td>{{$ticket->title}}</td>
				<td>{{$ticket->piece}}</td>
				<td class="text-right">{{$ticket->price}} {!! $html !!}</td>
				<td class="text-right">{{$ticket->sumprice}} {!! $html !!}</td>
			</tr>
				
		@endforeach	
		<tr>
			<td colspan="3"></td>
			<td  class="text-right">{{$data['reservation']->sumprice}} {!! $html !!}</td>
		</tr>

	</table>

	<div class="col-4">
	<form action="{{route('pay', app()->getLocale() )}}" method="GET">
		<input type="hidden" name="resrvation" value="{{$data['reservation']->id}}">

		
		@if($data['paymethods']!=NULL )
			@foreach($data['paymethods'] as $paymethod)
				<br>
				<input type="radio" name="paymethod" id="{{$paymethod->name}}" value="{{$paymethod->id}}"><label for="{{$paymethod->name}}">{{$paymethod->name}}
					@if($paymethod->name=="Sumup" || $paymethod->name =="sumup")
					<img src="/img/mastercard.png" width="40px" height="40px">
					<img src="/img/visa.png" width="40px" height="40px">
					@endif
				</label>
			@endforeach
		@endif		
		<br>
		<input type="submit" name="submit" value="submit" class="btn btn-info">
	</form>
	</div>
</div>
@endsection