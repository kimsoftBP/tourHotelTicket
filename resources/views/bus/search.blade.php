@extends('view')
@section('includecontent')

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



<script type="text/javascript">
$(function() {

  $('input[name="daterange"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
  });

  $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

});
</script>
{{--
<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>
--}}
@endsection
@section('content')
<div class="col-lg-10">
	<form>
		<div class="row">
			<label class="d-none d-lg-block col-form-label">{{__('messages.from')}}</label>
			<div class="col-3 col-md-2 col-lg-2">
				<input class="form-control @error('from') is-invalid @enderror" type="text" name="from" placeholder="{{__('messages.from')}}" required value="{{old('from',$data['search']['from'])}}">
			</div>
			<label class="d-none d-lg-block col-form-label">{{__('messages.date')}}</label>
			<div class="">
				<input class="form-control @error('daterange') is-invalid @enderror" type="text" name="daterange" value="{{old('daterange',$data['search']['range'])}}" autocomplete="off" placeholder="{{__('messages.dateRange')}}" />
			</div>
			<label class="d-none d-lg-block col-form-label">{{__('messages.persons')}}</label>
			<div class="col-5 col-md-2 col-lg-1">
				<input type="number" name="persons" class="form-control @error('persons') is-invalid @enderror" placeholder="{{__('messages.persons')}}" min="1" required value="{{old('persons',$data['search']['persons'])}}">
			</div>
			<button class="btn ">{{__('messages.search')}}</button>
		</div>
	</form>

	<div>
		<table class="table">
			<tr>
				<th></th>
			</tr>
			@php
				$lastCompanyid=NULL;
			@endphp
			@if($data['bus']!=NULL)
				@foreach($data['bus'] as $row)
					<tr>
						@if($lastCompanyid==NULL || $lastCompanyid!=$row->bus_companyid)	
							<td>{{$row->BusCompany->country->name}}</td>
							<td>{{$row->BusCompany->city}}</td>
						@else
							<td colspan="2"></td>
						@endif
						<td>{{$row->BusType->brand}} {{$row->BusType->name}}</td>
						<td>{{$row->passenger_seats}}</td>

					</tr>
					@php
						$lastCompanyid=$row->bus_companyid;
					@endphp
				@endforeach 
			@endif
		</table>
	</div>
</div>
@endsection