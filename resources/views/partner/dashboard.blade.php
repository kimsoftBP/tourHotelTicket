@extends('partner.view')
@section('subincludecontent')

@endsection
@section('subcontent')
<div>
	<h5>{{__('messages.dashboard')}}</h5>
	<div class="col-6 float-left">
		<div>
			<h4>Sales: </h4>
		</div>
		<h4>{{__('messages.ordernumber')}}</h4>
		<table class="table table-hover">
			@foreach($data['order'] as $row)
			<tr>
				<td>{{$row->year}}/{{$row->month}}</td>
				<td>{{$row->num}}</td>
			</tr>
			@endforeach
		</table>
	</div>
	<div class="col-6 float-left">
		<h4>{{__('messages.mostsoldproduct')}}</h4>
		<table class="table table-hover">
			<tr>
				<th>{{__('messages.city')}}</th>
				<th>{{__('messages.category')}}</th>
				<th>%</th>
			</tr>

			@foreach($data['soldstat'] as $row)
				<tr>
					<td>{{$row->countryname}}/{{$row->cityname ?? ''}}</td>
					<td>{{$row->categoryname}}</td>
					<td>{{$row->num}}</td>
				</tr>
			@endforeach

			
			{{--
			@foreach($data['soldr'] as $row)
				@php
					print_r($row);
				@endphp
				<tr>
					<td>
						
						{{$row['country'] ?? ''}}/ 
						
						@if(isset($row['city']))
							{{$row['city']}}						
						@endif
					</td>
					<td>{{$row['category'] ?? ''}}</td>
					<td>
						@if(isset($row['lastmonthnum']) && isset($row['num']) && $row['num']!=0)
							{{$row['lastmonthnum']/($row['num']/100)-100}}
						@endif
					</td>
					<td>{{$row['num'] ?? ''}}</td>
					<td>{{$row['lastmonthnum'] ?? ''}}

				</tr>
			@endforeach
			--}}

			<tr>
				<td>
				</td>
			</tr>
			@foreach($data['sold'] as $row)
				<tr>
					<td>
						{{$row->product->country->name}}/

						@if($row->product->city!=NULL)
							{{$row->product->city->name}}
						@endif
					</td>
					<td>{{$row->product->category->name}}</td>
					<td>{{$row->num}}</td>
					<td>{{$row->year}}</td>
					<td>{{$row->month}}</td>
				</tr>
			@endforeach
			
		</table>

		<h4>{{__('messages.mostclickedproducts')}}</h4>
		<table class="table table-hover">
			<tr>
				<th>{{__('messages.country')}}</th>
				<th>{{__('messages.city')}}</th>
				<th>{{__('messages.category')}}</th>

				<th>{{__('messages.click')}}</th>
				<th>{{__('messages.date')}}</th>
			</tr>
			@foreach($data['click'] as $row)
				<tr>					
					<td>{{$row->countryname}}</td>
					<td>{{$row->cityname}}</td>
					<td>{{$row->categoryname}}</td>

					<td>{{$row->num}}</td>
					<td>{{$row->year}}/{{$row->month}}</td>					
				</tr>
			@endforeach
		</table>
	</div>
</div>
@endsection