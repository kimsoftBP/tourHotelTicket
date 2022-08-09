
@extends('view')
@section('includecontent')
<title>{{__('page.hotelSearchTitle')}}</title>
<meta property="og:title" content="{{__('page.hotelSearchTitle')}}" />
<meta property="og:description" content="{{__('page.hotelSerachDescription')}}"/>
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:site_name" content="{{__('page.sitename')}}" />
<meta name="robots" content="index, follow" />


<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



<script type="text/javascript">
	
$(function() {

  $('input[name="daterange"]').daterangepicker({
      autoUpdateInput: false,
      	@if(isset($data['search']['fromdateObj']) && isset($data['search']['todateObj']))
      		@php
				$fromdate=$data['search']['fromdateObj'];
				$todate=$data['search']['todateObj'];
			@endphp
		      startDate: '{{$fromdate->month}}/{{$fromdate->day}}/{{$fromdate->year}}',
		       endDate: '{{$todate->month}}/{{$todate->day}}/{{$todate->year}}',
		@endif
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

@endsection
@section('content')


<div class="col-lg-10 " style="clear:both">
	<div class="col-12 p-0">
			<form>
				<div class="row ">
					<label class="d-none d-lg-block col-form-label">{{__('messages.where')}}</label>
					<div class="col-12 col-md-2 col-lg-2">
						<input class="form-control @error('from') is-invalid @enderror" type="text" name="from" placeholder="{{__('messages.City')}}" required value="{{old('from',$data['search']['from'])}}">
					</div>
					<label class="d-none d-lg-block col-form-label">{{__('messages.date')}}</label>
					<div class="d-flex pl-2 pr-3">
						<input class="form-control @error('daterange') is-invalid @enderror" type="text" name="daterange" value="{{old('daterange',$data['search']['range'])}}" autocomplete="off" placeholder="{{__('messages.dateRange')}}" />
					</div>
					<label class="d-none d-lg-block col-form-label">{{__('messages.persons')}}</label>
					<div class="col-5 col-md-2 col-lg-1">
						<input type="number" name="persons" class="form-control @error('persons') is-invalid @enderror" placeholder="{{__('messages.persons')}}" min="1" required value="{{old('persons',$data['search']['persons'])}}">
					</div>
					<button class="btn btn-primary">{{__('messages.search')}}</button>
				</div>
			</form>
	</div>
<div>
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
	<div class="mt-3 d-flex justify-content-center">
		<table class="table">
			<!--<tr>
				<th></th>
			</tr>
		-->
			@php
				$lastCompanyid=NULL;
			@endphp
			@if($data['hotel']!=NULL)
				@foreach($data['hotel'] as $row)
					<tr>
						<td>{{$row->country->name}}</td>
						<td>{{$row->city}}</td>
						<td>
							<a class="btn btn-sm btn-primary" href="{{route('hotel.customer.message',['locale'=>app()->getLocale(),'from'=>$data['search']['from'],'fromdate'=>$data['search']['fromdate'],'todate'=>$data['search']['todate'],'comp'=>$row->id,'persons'=>$data['search']['persons'] ])}}">
							<i class="bi bi-envelope-plus-fill"></i>
							</a>
						</td>
					</tr>
					@php
						
					@endphp
				@endforeach 
			@endif
		</table>
	</div>
</div>
@endsection