@extends('view')
@section('includecontent')

@endsection
@section('content')
<div>	
	<table class="table table-hover">
		@foreach($data['orders'] as $order)
			<tr>
				<td>{{$order->cloneproduct->title}}</td>
				<td>{{$order->cloneproduct->country->name}}/
					@if($order->cloneproduct->city!=NULL)
						{{$order->cloneproduct->city->name}}
					@endif
				</td>
				<td>{{$order->person}}</td>
				<td>{{$order->sumprice}} {!! $order->currency->html !!}</td>
			</tr>
		@endforeach
	</table>
</div>
@endsection