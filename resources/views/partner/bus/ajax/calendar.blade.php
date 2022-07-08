<div class="col-12" style="overflow-x: scroll;">
	<div class="col-12 p-0 row">
		<nav aria-label="...">
		  <ul class="pagination">
		    <li class="page-item">
		      <a class="page-link" href="#" tabindex="-1" onclick="loadcalendar({{$data['id']}},{{$data['previousYear']}},{{$data['previousMonth']}}) ">Previous</a>
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
		      <a class="page-link" href="#" onclick="loadcalendar({{$data['id']}},{{$data['nextyear']}},{{$data['nextmonth']}}) ">Next</a>
		    </li>
		  </ul>
		</nav>
		<div class="col-7 d-flex  flex-row-reverse">
			<div>
				<button onclick="setNewBAI({{$data['bus']->id}})" class="btn btn-info" data-toggle="modal" data-target="#newCalendarIntervallumModal">+</button>
			</div>
		</div>
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

				$i=0;
			@endphp
			@while($data['month']==$data['startdate']->format('m'))
				@if($data['startdate']->dayName=="Monday" && $data['startdate']->format('d')!=1)
					</tr>
					<tr>		
						@if($firstrow && $toweekday>1)
							<td colspan="{{$toweekday-1}}"></td>
							@php $firstrow=0; @endphp
						@endif
						
						
							@if($data['availableCalendar']!=NULL)								
								@while($act<=$weeklastday)
									@php 
										$length=1;
										$empty=1;
									@endphp
									@while($k<$records && $data['availableCalendar'][$k]->day<=$act )
										@php
										if($data['availableCalendar'][$k]->day<$act){
											$k++;
											continue;
										}
											$empty=0;										
											$day=$data['availableCalendar'][$k]->day;
											
											$calendarintervall=$data['availableCalendar'][$k]->available;
											$available=$calendarintervall->available->name;
											$availablebg="";
											switch ($available) {
											    case 'Available':
											    	$availablebg="bg-success";
											        break;
											    case 'Pending':
											    	$availablebg="bg-primary";
											    	break;
											    case 'Reserved':
											    	$availablebg="bg-danger";
											    	break;
											    
											    default:
											        // code...
											        break;
											}

											$length=1;
											$knext=1;
											$daysLeftThisWeek=$weeklastday-$day+1;
											$toAndEndDayDiff=$calendarintervall->diff($data['year']."-".$data['month']."-".$act);
											if($daysLeftThisWeek > $toAndEndDayDiff ){
												$length=$toAndEndDayDiff+1;
												$knext=$toAndEndDayDiff;
											}else{
												$length=$daysLeftThisWeek;
												$knext=$daysLeftThisWeek;
											}
											if($length==0){
												$length=1;
											}
											if($knext==0){
												$knext=1;
											}
										@endphp
										<td colspan="{{$length}}">
											<div onclick="editCalendarIntervallum()" class="progress cursor-pointer" class="" style="margin-left:10px ; margin-right:10px; cursor: pointer;">
											  <div class="progress-bar {{$availablebg}}" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">  </div>
											</div>
										@php
											$k+=$knext;
											//$k++;
										@endphp
									@endwhile
									@if($empty)
										<td>
									@endif
									</td>
									@php
										$act+=$length;
										//$act++;
									@endphp
								@endwhile
							@endif
						

						<!--				
						<td colspan="2">
							<div onclick="editCalendarIntervallum()" class="progress cursor-pointer" class="" style="margin-left:15px ; margin-right:15px; cursor: pointer;">
							  <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">14:00 - 10:00</div>
							</div>
						</td>
						<td colspan="2">
							<div class="progress" class="" style="margin-left:15px ; margin-right:15px">
							  <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">daf</div>
							</div>
						</td>
						<td colspan="2">
							<div class="progress" class="" style="margin-left:-35px ; margin-right:15px">
							  <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">daf</div>
							</div>
						</td>-->
					</tr>
					<tr>
				@endif
					<th class="f
						{{$data['startdate']->toDateString()==now()->toDateString() ? 'bg-warning':''}}				
						{{$data['startdate']->dayName=='Saturday' ? 'text-primary':''}}
						{{$data['startdate']->dayName=='Sunday' ? 'text-danger':''}}
						
					">
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
			<!--
					<tr>						
						<td colspan="1">
							<div class="progress" class="" style="margin-left:15px ; margin-right:15px">
							  <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">daf</div>
							</div>
						</td>
					</tr>-->
		
		</tr>
	</table>
</div>