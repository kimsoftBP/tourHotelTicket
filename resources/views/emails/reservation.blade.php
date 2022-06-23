</!DOCTYPE html>
@php app()->setLocale($data['locale']); @endphp
<html lang="{{$data['locale']}}">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


		<style type="text/css">
.table td,.table th{padding:.75rem;vertical-align:top;border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table .table{background-color:#fff}.table-sm td,.table-sm th{padding:.3rem}.table-bordered{border:1px solid #dee2e6}.table-bordered td,.table-bordered th{border:1px solid #dee2e6}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}.table-hover tbody tr:hover{background-color:rgba(0,0,0,.075)}.table-primary,.table-primary>td,.table-primary>th{background-color:#b8daff}.table-hover .table-primary:hover{background-color:#9fcdff}.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th{background-color:#9fcdff}.table-secondary,.table-secondary>td,.table-secondary>th{background-color:#d6d8db}.table-hover .table-secondary:hover{background-color:#c8cbcf}.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th{background-color:#c8cbcf}.table-success,.table-success>td,.table-success>th{background-color:#c3e6cb}.table-hover .table-success:hover{background-color:#b1dfbb}.table-hover .table-success:hover>td,.table-hover .table-success:hover>th{background-color:#b1dfbb}.table-info,.table-info>td,.table-info>th{background-color:#bee5eb}.table-hover .table-info:hover{background-color:#abdde5}.table-hover .table-info:hover>td,.table-hover .table-info:hover>th{background-color:#abdde5}.table-warning,.table-warning>td,.table-warning>th{background-color:#ffeeba}.table-hover .table-warning:hover{background-color:#ffe8a1}.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th{background-color:#ffe8a1}.table-danger,.table-danger>td,.table-danger>th{background-color:#f5c6cb}.table-hover .table-danger:hover{background-color:#f1b0b7}.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th{background-color:#f1b0b7}.table-light,.table-light>td,.table-light>th{background-color:#fdfdfe}.table-hover .table-light:hover{background-color:#ececf6}.table-hover .table-light:hover>td,.table-hover .table-light:hover>th{background-color:#ececf6}.table-dark,.table-dark>td,.table-dark>th{background-color:#c6c8ca}.table-hover .table-dark:hover{background-color:#b9bbbe}.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th{background-color:#b9bbbe}.table-active,.table-active>td,.table-active>th{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover>td,.table-hover .table-active:hover>th{background-color:rgba(0,0,0,.075)}.table .thead-dark th{color:#fff;background-color:#212529;border-color:#32383e}.table .thead-light th{color:#495057;background-color:#e9ecef;border-color:#dee2e6}.table-dark{color:#fff;background-color:#212529}.table-dark td,.table-dark th,.table-dark thead th{border-color:#32383e}.table-dark.table-bordered{border:0}.table-dark.table-striped tbody tr:nth-of-type(odd){background-color:rgba(255,255,255,.05)}.table-dark.table-hover tbody tr:hover{background-color:rgba(255,255,255,.075)}@media (max-width:575.98px){.table-responsive-sm{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-sm>.table-bordered{border:0}}@media (max-width:767.98px){.table-responsive-md{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-md>.table-bordered{border:0}}@media (max-width:991.98px){.table-responsive-lg{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-lg>.table-bordered{border:0}}@media (max-width:1199.98px){.table-responsive-xl{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-xl>.table-bordered{border:0}}.table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive>.table-bordered{border:0}

		</style>
	</head>
	<body>
		<div>		

			<div style="padding-top:10px; padding-bottom: 10px;">
				<h3>{{ config('app.name') }}</h3>
			</div>
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
		</div>
  </body>
</html>