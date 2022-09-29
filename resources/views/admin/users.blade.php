@extends('admin.view')
@section('subincludecontent')

@endsection
@section('subcontent')

	@if($errors->any())
		<div class="alert text-danger">
			{{ implode('', $errors->all(':message')) }}
		</div>
	@endif
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


<button class="btn btn-info" data-toggle="modal" data-target="#exampleModal">+</button>
<div class="pb-4">
	<form>
		<select class="form-control col-4 col-md-3 float-left" name="lang">
			<option value=""></option>
			@foreach($data['language'] as $lang)
				<option value="{{$lang->name}}" {{app('request')->input('lang')==$lang->name ? 'selected':''}} >{{__('messages.'.$lang->name)}}</option>
			@endforeach
		</select>
		<select class="form-control col-4 col-md-3 float-left" name="country">
			<!--<option selected>{{__('messagaes.country')}}</option>-->
			<option value=""></option>
			@foreach($data['country'] as $c)			
				@if($c->country !=NULL)
					<option value="{{$c->country->name}}" {{app('request')->input('country')==$c->country->name ? 'selected':''}} >
						{{$c->country->name}}
					</option>	
				@endif	
			@endforeach
		</select>
		<select class="form-control col-4 col-md-3 float-left" name="city">
			<option value=""></option>
			@foreach($data['city'] as $city)
				<option value="{{$city->city}}" {{app('request')->input('city')==$city->city ? 'selected':''}} >{{$city->city}}</option>
			@endforeach
		</select>
		<input type="submit" class="btn btn-primary" name="submit" value="{{__('messages.search')}}">
	</form>
</div>


<div>
	<table class="table table-hover">
		<tr>
			<th></th>
			@php
				$sorted="ASC";
				if($data['orderby']=="name"){
					$sorted=$data['orderbysortedinv'];
				}
			@endphp
			<th>
				<a href="?page={{$data['page']}}&{{$data['url']}}&orderby=name&orderbysorted={{$sorted}}">
				{{__('messages.name')}}
				</a>
				@if(isset($data['orderby']) && $data['orderby']=='name')
					@if($data['orderbysorted']=="ASC")
					<!-- up -->
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
						</svg>
					@else
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
						</svg>
					@endif
				@endif
			</th>
			@php
				$sorted="ASC";
				if($data['orderby']=="email"){
					$sorted=$data['orderbysortedinv'];
				}
			@endphp
			<th>
				<a href="?page={{$data['page']}}&{{$data['url']}}&orderby=email&orderbysorted={{$sorted}}">
					{{__('messages.email')}}
				</a>
				@if(isset($data['orderby']) && $data['orderby']=='email')
					@if($data['orderbysorted']=="ASC")
					<!-- up -->
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
						</svg>
					@else
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
						</svg>
					@endif
				@endif
			</th>
			@php
				$sorted="ASC";
				if($data['orderby']=="created_at"){
					$sorted=$data['orderbysortedinv'];
				}
			@endphp
			<th>
				<a href="?page={{$data['page']}}&{{$data['url']}}&orderby=created_at&orderbysorted={{$sorted}}">
				{{__('messages.registrationdate')}}
				</a>
				@if(isset($data['orderby']) && $data['orderby']=='created_at')
					@if($data['orderbysorted']=="ASC")
					<!-- up -->
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
						</svg>
					@else
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
						</svg>
					@endif
				@endif
			</th>
		</tr>
		@foreach($data['users'] as $user)
		<tr>
			<td scope="" class=""><a href="{{route('admin.users.edit', ['locale'=>app()->getLocale() , 'user'=>$user->id] )}} " class="btn btn-info">{{__('messages.edit')}}</a></td>
			<td>{{$user->name}}</td>
			<td>{{$user->email}}</td>		
			<td>{{$user->created_at}}</td>
		</tr>
		@endforeach
	</table>
</div>

<div>
	@php
		$from=$data['page']-2;
		$to=$data['page']+2;
		if($from<=0){
			$from=1;
		}
		if($to>$data['pages']){
			$to=$data['pages'];
		}
	@endphp
	<nav aria-label="Page navigation example">
	  <ul class="pagination justify-content-center">
	    <li class="page-item {{$data['page']==1 ? 'disabled':''}}" ><a class="page-link" href="{{route('admin.users', app()->getLocale())}}?page={{$data['page']-1}}&{{$data['url']}}">Previous</a></li>
	    @for($i=$from;$i<=$to;$i++)
	    	<li class="page-item {{$i==$data['page'] ? 'disabled':''}}">
	    		<a class="page-link" href="{{route('admin.users', app()->getLocale())}}?page={{$i}}&{{$data['url']}}">{{$i}}</a>
	    	</li>
	    @endfor
	    <li class="page-item {{$data['page']==$data['pages'] ? 'disabled':''}}"><a class="page-link" href="{{route('admin.users', app()->getLocale())}}?page={{$data['page']+1}}&{{$data['url']}}">Next</a></li>
	  </ul>
	</nav>
</div>


@endsection
@section('submodalconent')

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('admin.addnewuser',app()->getLocale())}}" method="post">
      <div class="modal-body">
        				@csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('messages.name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('messages.emailaddress') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('messages.password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('messages.confirmpassword') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                        	<label class="col-md-4 col-form-label text-md-right">{{__('messages.country')}}</label>
                        	<div class="col-md-6">
	                        	<select name="country" class="form-control">
	                        		@foreach($data['allcountry'] as $country)
	                        			<option value="{{$country->id}}">{{$country->name}}</option>
	                        		@endforeach
	                        	</select>
	                        </div>
                        </div>
                        @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <div class="form-group row">
                        	<label class="col-md-4 col-form-label text-md-right">{{__('messages.city')}}</label>
                        	<div class="col-md-6">
                        		<input type="text" name="city" class="form-control" value="{{old('city')}}">
                        	</div>
                        </div>
                        @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  class="btn btn-primary">Save</button>
      </div>
  	</form>
    </div>
  </div>
</div>
@endsection