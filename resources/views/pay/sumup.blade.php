@extends('view')
@section('includecontent')

@endsection

@section('content')
<div>
	<div class="col-lg-5" style="text-align: center;margin:auto;padding-top: 20px;">
		
	<div>
		<div>{{--
			@php
			$v2=str_replace('.',',',round($priceeuro*$won,0));
			@endphp
			--}}
			<br>
				<h2>{!! $showoriginprice !!}</h2>
				<h6>{{$price ?? ''}}  
					{!! $currency->html !!} 
				</h6>
		</div>
		@if ($error)
			<div>Payment error</div>
		@else
		<div id="sumup-card"></div>
		<div id="status"></div>
		<div id="fail" style="display: none">{{__('messages.payfail')}}</div>
		<div id="tanks" style="display: none">{{__('messages.thankyouwecontact')}}</div>
		@endif
	</div>
		<script type="text/javascript" src="https://gateway.sumup.com/gateway/ecom/card/v2/sdk.js"></script>
		<script type="text/javascript">
		//document.addEventListener('load', function() {
		window.addEventListener('load', function() {
		    var sumupCard =SumUpCard.mount({
				checkoutId: '{{$checkoutId ?? ''}}',
				locale: '{{$sumuplang}}',
				currency: '{{$currency->code}}',
				onResponse: function(type, body,param3,param4,param5) {
				    console.log('Type', type);
				    console.log('Body', body);
				    console.log('param3',param3);
				    console.log('param4',param4);
				    console.log('param5',param5);
				     //console.log('Response from client', res);			    
				    if(type!='invalid'){
				    	if(type=='error'){

				    	}
				     //	sumupCard.unmount();			     
				     //	hidesumup(); 
			    	}
			    	if(type=='success'){
			    		console.log('status',body.status);
			    		
						$("#status").text("Payment status: "+body.status);
						$('#sumup-card').hide();

						if(body.status=="FAILED"){
							$('#fail').show();
						}else{
							$('#tanks').show();
						}

						//hidesumup();
						
			    	}
				}
			});

		});
		$(document).ready(function(){
		  setTimeout(function() {
		  	$('#sumup-card').hide();
		  }, 300000);
		});
		function hidesumup(){
			$('#sumup-card').hide();
			$('#tanks').show();
		}

		</script>
	</div>
</div>
@endsection