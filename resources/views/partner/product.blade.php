@extends('partner.view')
@section('subincludecontent')
<script type="text/javascript">
	function setdelete(value){
		$("#delete").val(value);
	}
</script>
@endsection
@section('subcontent')

<div>
	<a href="{{route('partner.product.add',app()->getLocale())}}" class="btn btn-primary">+</a>
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

	<div style="overflow-x: scroll;">
		<table class="table">
			<tr>
				<th></th>
				<th></th>
				<th>{{__('messages.category')}}</th>
				<th>{{__('messages.tourtitle')}}</th>

			</tr>
			@foreach($data['products'] as $product)
				@php
					$ch=0;
				@endphp
				<tr>
					<td>						
						<a href="{{route('partner.product.editpage1',['locale'=>app()->getLocale(),'product'=>$product->id])}}" class="btn btn-sm btn-info">{{__('messages.edit')}}</a>
						<button class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#deletemodal" onclick="setdelete({{$product->id}})">{{__('messages.delete')}}</button>
					</td>
					<td>
						
						@if($product->page1 && $product->page2 && $product->page3)
							@if($product->confirmlog->whereNull('confirmbyuserid')->first()!=NULL ||$product->checkadmin!=1 || $product->tourcourse->where('checkadmin',0)->first()!=NULL
							|| $product->tourcoursechange()
							{{--
							|| $product->ticket->where('checkadmin',0)!=NULL 
							--}}
							)
								@php
									$ch=1;
								@endphp
								<span class="bg-warning p-2">{{__('messages.notconfirmed')}}</span>
							@else
								<span class="bg-success p-2">ok</span>
							@endif
						@else
							
						@endif
					</td>
					<td>
						@if(isset($product->category))
							{{$product->category->name}}
						@endif
					</td>
					<td>
						{{$product->title}}
					</td>
					

					<td>
						{{$product->onelinesummary}}
					</td>
				</tr>
				@if($ch==1)
				
					<tr class="border-top-0">
						<!--<td colspan="5" class="text-danger border-top-0">-->
						<form method="post" action="{{route('partner.product.answare',app()->getLocale() )}}">
							<td colspan="5" class="border-top-0">								
								@csrf
								<div class="border0 p-2">
								@php
									$reply="";
									$type="";
								@endphp
								@foreach($product->confirmmessageASC->where('created_at'> $product->updated_at) as $message )
									<div class="col-12 {{$message->fromuserid==$product->userid ? 'text-right':''}} p-1">
										<span class="bg-secondary rounded p-2 mw-75 text-white"> 
											{{$message->text}}
										</span>
										<br>
										<span class="">
											<small>
											{{$message->created_at}}
											</small>
										</span>
									</div>
									@php
										$reply=$message->id;
										$type=$message->typeid;
									@endphp
								@endforeach
								</div>
								
								<input type="hidden" name="replyby" value="{{$reply}}">
								<input type="hidden" name="product" value="{{$product->id}}">
								<input type="hidden" name="type" value="{{$type}}">

								<div class="input-group">
									<textarea class="form-control" name="text"></textarea>
									<button class="btn btn-info">{{__('messages.send')}}</button>			
	<!--								<div class="input-group-prepend">
										<button class="btn btn-info">{{__('messages.send')}}</button>			
									</div>-->
								</div>
							</td>
						</form>
					</tr>
				@endif
			@endforeach
		</table>
	</div>
</div>
@endsection
@section('submodalconent')


<!-- Modal -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<form method="post" action="{{route('partner.product.delete',app()->getLocale())}}">
  		@csrf
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{__('messages.delete')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <input type="hidden" id="delete" name="delete" value="">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
	        <button class="btn btn-danger">{{__('messages.delete')}}</button>
	      </div>
	    </div>
	</form>
  </div>
</div>
@endsection