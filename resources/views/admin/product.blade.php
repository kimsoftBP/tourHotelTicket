@extends('admin.view')
@section('subincludecontent')

<script type="text/javascript" >
	function getproduct(id) {
        $.ajax({
           type:'get',
           url:'/en/admin/ajax/product',
           data:{"id":id
       			},
         //  data:'_token = <?php echo csrf_token() ?>',
           success:function(data) {
              $("#country2").html(data.msg);
           }
        });
     //   $('#exampleModal').modal('show');
    }
   	function testpost() {
   		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
           type:'post',
           url:'/en/admin/product/confirm',
           data:{_token: CSRF_TOKEN, "id":2
       			},
         //  data:'_token = <?php echo csrf_token() ?>',
           success:function(data) {
              $("#country2").html(data.msg);
           }
        });
     //   $('#exampleModal').modal('show');
    }
</script>
@endsection
@section('subcontent')
<div>	
	<div>
		
	</div>
	<div class="" style="overflow-x: scroll;">
		<table class="table">
			<tr>
				<th></th>
				<th>{{__('messages.country/city')}}</th>
				
				<th></th>
				<th>{{__('messages.')}}</th>			
			</tr>
		@foreach($data['product'] as $product)
			<tr id="tablerow{{$product->id}}" onclick="getproduct({{$product->id}})" data-toggle="modal" data-target="#exampleModal">
				<td>{{$product->user->email}}</td>
				<td>{{$product->checkadmin==0 ? 'create':'update/photo'}}</td>
				<td>{{$product->country->name}}/{{$product->city->name ?? ''}}</td>
				<td>{{$product->title}}</td>
				<td>{{$product->created_at}}</td>
			</tr>
		@endforeach
		</table>
	</div>
					<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  	@php
				  		$showpages=2;

				    	$i=$data['page']-$showpages;
				    	if($i<1){$i=1;}
				    	$to=$data['page']+$showpages;
				    	if($to>$data['pages']){$to=$data['pages'];}
				    @endphp
				    <li class="page-item {{$data['page']>1 ? '':'disabled'}}"><a class="page-link" href="{{route('admin.product',['locale'=>app()->getLocale() ] )}}?page={{$data['page']-1}}&{{$data['url']}}">Previous</a></li>				    
				    @for(;$i<=$to;$i++)
				    	<li class="page-item {{$i==$data['page']? 'disabled':''}}" ><a class="page-link" href="{{route('admin.product',['locale'=>app()->getLocale() ] )}}?page={{$i}}&{{$data['url']}}">{{$i}}</a></li>
				    @endfor
				    <li class="page-item {{$data['page']<$data['pages'] ? '':'disabled'}}"><a class="page-link" href="{{route('admin.product',['locale'=>app()->getLocale() ] )}}?page={{$data['page']+1}}&{{$data['url']}}">Next</a></li>
				  </ul>
				</nav>
</div>

<!-- Button trigger modal -->
<!--
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >
  Launch demo modal
</button>
<input id="region2" type="" name="" value="Western europe">
-->
@endsection
@section('submodalconent')
<!-- Modal -->
{{--
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
        ...
      </div>
      
    </div>
  </div>
</div>
--}}

<div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog modal-lg col0-10" role="document">
	  	<form>
	  		<input type="hidden" name="">


		    <div class="modal-content">	      
		    	<div class="modal-header">
			        
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			    </div>
			    <div class="modal-body" id="country2">
				      	
			    </div>	      

			    <div class="border-top">

			    </div>
		    </div>		
		</form>
	  </div>
	</div>
</div>


@endsection