@extends('view')
@section('includecontent')
<style type="text/css">
.destination-header{
	    background-position: bottom;
    background-repeat: no-repeat;
    background-size: cover;
}
.backgroundgray{
		background-color: rgba(0,0,0,.4);
}
</style>
<style type="text/css">
	.region-name {
    color: #adb5bd;
    display: inline-block;
    font-size: 20px;
    font-weight: 500;
    position: absolute;
    width: 100px;
}
.region-list {
    display: block;
    margin-right: -20px;
    padding-left: 118px;
}
.region-container {
    display: inline-block;
    margin-bottom: 40px;
    margin-right: 20px;
    vertical-align: top;
    width: 200px;
}
 .subregion-name {
    border-bottom: 1px solid #e9ecef;
    color: #adb5bd;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 5px;
    padding-bottom: 5px;
}
ul{    
    list-style: none;
    margin: 0;
    padding: 0;
}
.countrylist{
    color: #343a40;
    cursor: pointer;
}
</style>

<script type="text/javascript">
	function showcities(cname){
		$.ajax({
           type:'get',
           url:'/en/ajax/cities',
           data:{"id":cname
       			},
         //  data:'_token = <?php echo csrf_token() ?>',
           success:function(data) {
              $("#city").html(data.msg);
              $("#city").removeAttr('disabled');
           }
        });

		$("#citymodal").modal('show');
	//	$("#citymodal").trigger('focus');
		//$("#myLargeModalLabel").show();
	}
	function getCity() {
        
    }
</script>
@endsection
@section('content')
<div>
	<div class="backgroundgray" style="padding-top: -10px">
		<div class="destination-header" style="background-image: url('/image/region.jpg'); padding-bottom: 000px;">
			<div class="backgroundgray"  style="padding-bottom: 250px;padding-top: 50px;">
				<div class="col-lg-10 " style="margin: auto; color: white">
					<h4>{{__('messages.AllDestinations')}}</h4>
				</div>
			</div>

		</div>
	</div>
	<div class="col-lg-10" style="margin: auto;padding-top: 40px;">
		@foreach($data['continent'] as $continent)
		<div class="region-name"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{__('messages.'.$continent->name)}}</font></font></div>
		<ul class="region-list clearfix">
			@if($continent->regions()!=NULL)
				
				@php
				//	print_r($continent->regions );
				@endphp
				@foreach($continent->regions as $region)
				<li class="region-container">
					<div class="subregion-name">
						<font style="vertical-align: inherit;">
							<font style="vertical-align: inherit;">{{__('messages.'.$region->name)}}
							</font>
						</font>
					</div>
					<ul class="region-inner-container">
						@if($region->country!=NULL)
							@foreach($region->country as $country)
								<li class="gm-region-country">
									<div class="inner-item"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;" >
									<!--onclick="showcities()"-->
									<span class="countrylist" onclick="showcities('{{$country->name}}')">
										{{__('messages.'.$country->name)}}
										</span>
									</font></font></div>
								</li>
							@endforeach
						@endif
					</ul>
				</li>
				@endforeach
			@endif
		</ul>
		@endforeach

		
	</div>
</div>

	




<!-- Large modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

<div id="citymodal" class="modal  fade 3bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="top: 0;">
  <div class="modal-dialog modal-lg  fixed-bottom" style="top: auto;">
    <div class="modal-content" style="padding: 20px;">
      <div id="city">
      </div>
    </div>
  </div>
</div>

@endsection