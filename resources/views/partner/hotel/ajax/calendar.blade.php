<div class="col-12" style="overflow-x: scroll;">
	<div class="col-12 p-0 row">
		<input type="hidden" name="year" value="{{$data['year']}}">
		<input type="hidden" name="month" value="{{$data['month']}}">
		<input type="hidden" name="rid" value="{{$data['room']->id}}">
		<nav aria-label="...">
		  <ul class="pagination">
		    <li class="page-item">
		      <a class="page-link" href="#" tabindex="-1" onclick="loadCalendar({{$data['id']}},{{$data['previousYear']}},{{$data['previousMonth']}}) ">Previous</a>
		    </li>
		    {{--
		    @if($data['month']>1)
		    	<li class="page-item"><a class="page-link" href="#">{{$data['month']-1}}</a></li>
		    @endif
		    --}}
		    <li class="page-item active">
		      <a class="page-link disabled" href="#">{{$data['year']}}/{{$data['month']}}<span class="sr-only">(current)</span></a>
		    </li>
		    {{--
		    <li class="page-item"><a class="page-link" href="?month={{$data['month']}}">{{$data['month']+1}}</a></li>
		    --}}
		    <li class="page-item">
		      <a class="page-link" href="#" onclick="loadCalendar({{$data['id']}},{{$data['nextyear']}},{{$data['nextmonth']}}) ">Next</a>
		    </li>
		  </ul>
		</nav>
	</div>
	<table class="table table-bordered  w-auto small text-small">
		<tr>
			@php
				$toweekday=$data['startdate']->weekday();
				if($toweekday==0){
					$toweekday=7;
				}
			@endphp
			@for($k=1;$k<$toweekday;$k++)
				<th></th>
			@endfor
			
			@php
				$firstrow=1;
				$k=0;
				$intervallday=1;
				$records=count($data['availableCalendar']);

				$weeklastday=0;
				$act=1;
				$EndLastWeek=1;
				$i=0;
			@endphp
			@while($data['month']==$data['startdate']->format('m'))
				@if($data['startdate']->dayName=="Monday" && $data['startdate']->format('d')!=1)
					</tr>
					<tr>		
						@if($firstrow && $toweekday>1)
							<td colspan="{{$toweekday-1}}"></td>
							@php $firstrow=0; @endphp
						@else
							@php $EndLastWeek=1; @endphp
						@endif
						@for(;$act<=$weeklastday;$act++)

							<td>
								@php
									$available=$data['room']->availableDate($data['year'].'-'.$data['month'].'-'.$act)->first()??NULL;
								@endphp
								<div class="col-12 p-0">
								 	<input type="number" name="available[{{$act}}]" min="0" value="{{$available->piece??0}}" class="form-control p-0">
								</div>
							</td>
						@endfor
					</tr>
					<tr>
				@endif
					<th class="f
						{{$data['startdate']->toDateString()==now()->toDateString() ? 'bg-warning':''}}				
						{{$data['startdate']->dayName=='Saturday' ? 'text-primary':''}}
						{{$data['startdate']->dayName=='Sunday' ? 'text-danger':''}}">
						{{$data['startdate']->month}}/{{$data['startdate']->day}} {{__('messages.'.$data['startdate']->dayName)}}				
					</th>
				@php
					$t_dates[$i]=clone $data['startdate'];
					$weeklastday=$data['startdate']->day;
					$data['startdate']->addDay();
					$i++;					
				@endphp
			@endwhile
			<!-- last week row --->

			<!-- calendar last row intervallum show  start same copy past like before rows print-->
					<tr>		
						@if($firstrow && $toweekday>1)
							<td colspan="{{$toweekday-1}}"></td>
							@php $firstrow=0; @endphp
						@else
							@php $EndLastWeek=1; @endphp
						@endif
						
						@for(;$act<=$weeklastday;$act++)

							<td>
								@php
									$available=$data['room']->availableDate($data['year'].'-'.$data['month'].'-'.$act)->first()??NULL;
								@endphp
								<div class="col-12 p-0">
								 	<input type="number" name="available[{{$act}}]" min="0" value="{{$available->piece??0}}" class="form-control p-0">
								</div>
							</td>
						@endfor
					</tr>

			<!-- calendar last row intervallum show  end-->
		</tr>
	</table>
</div>