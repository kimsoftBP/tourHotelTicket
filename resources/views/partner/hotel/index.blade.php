@extends('partner.view')
@section('subincludecontent')

@endsection
@section('subcontent')
<div>
	<button class="btn btn-primary">{{__('messages.addRoom')}}</button>
	<table class="table table-hover">
		<tr>
			<th></th>
			<th></th>
			<th>{{__('messages.piece')}}</th>
			<th>{{__('messages.maximumPeople')}}</th>
		</tr>
		@foreach($data['hotel'] as $row)
			<tr>
				<td>
					<button class="btn btn-info">{{__('messages.edit')}}</button>
					<button class="btn btn-primary">{{__('messages.calendar')}}</button>
					<button class="btn btn-danger">{{__('messages.delete')}}</button>
					
				</td>
				<td>{{$row->name}}</td>
				<td>{{$row->piece}}</td>
				<td>{{$row->maximum_people}}</td>
			</tr>
		@endforeach
	</table>
</div>
@endsection