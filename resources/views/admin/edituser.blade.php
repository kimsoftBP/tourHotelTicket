@extends('admin.view')
@section('subincludecontent')
<script type="text/javascript">
	function addpermission(){
		@if(Auth::user()->permadmin() || Auth::user()->permcontinentadmin() )
		$("#permission").append("<div><select name=\"addpermission[]\"> @foreach($data['permissions'] as $row ) <option value=\"{{$row->id}}\">{{$row->perm_name}}</option> @endforeach </select><button class=\"btn btn-danger\" type=\"button\" onclick=\"rm(this)\">X</button></div>");
		@endif
	}
	function rm(em){
		$(em).parent().remove();
	}

	function addcontinent(){
		@if(Auth::user()->permadmin())
		$("#permcontinent").append("<div><select name=\"addcontinent[]\">@foreach($data['continents'] as $row) <option value=\"{{$row->id}}\">{{$row->name}}</option>@endforeach </select> <button class=\"btn btn-danger\" type=\"button\" onclick=\"rm(this)\">X</button></div>  ");
		@endif
	}
	function addcountry(){
		$("#permcountry").append("<div><select name=\"addcountry[]\">@foreach($data['country'] as $row) <option value=\"{{$row->id}}\">{{$row->name}}</option>@endforeach </select><button class=\"btn btn-danger\" type=\"button\" onclick=\"rm(this)\">X</button></div>");
	}
	function addlanguage(){
		$("#languages").append("<div><select name=\"addlanguage[]\">@foreach($data['lang'] as $row) <option value=\"{{$row->id}}\">{{$row->name}}</option>@endforeach </select><button class=\"btn btn-danger\" type=\"button\" onclick=\"rm(this)\">X</button></div>");
	}
</script>
@endsection
@section('subcontent')

<div class="col-lg-10" style="margin: auto;">
	<!--<h4>{{__('messages.profilemanagemant')}}</h4>-->
	<div style="margin-top: 20px;">

		<div class="col-lg-12 float-none" style="">		
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
				<form method="POST" action="{{ route('admin.users.edit',app()->getLocale()) }}" enctype="multipart/form-data">
                        @csrf
			<div class="card " >

			  <div class="card-body">		  		
			  	<div style="text-align: center; padding-bottom: 40px;padding-top: 20px;">
				  	<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
					  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
					  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
					</svg>
				</div>
				<input type="hidden" name="user" value="{{$user->id}}">
	<!--{{-- can edit name  phonenumber password--}} -->
			  	<div class="form-group row">
			  		  <label for="name" class="col-md-4 col-form-label text-md-right">
			  			{{__('messages.name')}}</label>
			  			 <div class="col-md-6">
			  				<input type="text" name="name" value="{{old('name',$user->name)}}">
			  			</div>
			  	</div>
			  	@error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			  	<div class="form-group row">
			  		  <label for="name" class="col-md-4 col-form-label text-md-right">
			  			{{__('messages.email')}}</label>
			  			<div class="col-md-6"> 
			  			{{$user->email}}
			  		</div>
			  	</div><!--
			  	@error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror-->
			  	<div class="form-group row">
			  		<label for="name" class="col-md-4 col-form-label text-md-right">
			  			{{__('messages.phonenumber')}}
			  		</label>
			  			<div class="col-md-6">
			  				<input type="text" name="phonenumber" value="{{old('phonenumber',$user->phonenumber)}}">
			  			</div>
			  	</div>
			  	@error('phonenumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <!--
                {{--
			  	<div class="form-group row">
			  		<label for="name" class="col-md-4 col-form-label text-md-right">
			  			{{__('messages.password')}}
			  		</label>
			  		<div class="col-md-6">
			  			
			  			<a href="{{route('account.changepassword',app()->getLocale())}}">{{__('messages.changepassword')}}</a>
			  		
			  		</div>
			  	</div>
			  	--}}
			  -->
			  	{{-- @if($user->permpartner())--}}
			  		<div class="form-group row">
			  			<label class="col-md-4 col-form-label text-md-right">{{__('messages.country')}}</label>
			  			<div class="col-md-6">
			  				<select class="form-control" name="country">
			  					<option></option>
			  					@foreach($data['country'] as $country)
			  						<option value="{{$country->id}}" {{old('country',$user->countryid)==$country->id ? 'selected':''}} >{{$country->name}}</option>
			  					@endforeach
			  				</select>
			  			</div>
			  		</div>

			  		<div class="form-group row">
			  			<label class="col-md-4 col-form-label text-md-right">{{__('messages.city')}}</label>
			  			<div class="col-md-6">
			  				<input type="text" class="form-control" name="city" value="{{old('city',$user->city)}}">
			  			</div>
			  		</div>
			   	{{-- @endif --}}


			  	@if(Auth::user()->permadmin() || Auth::user()->permcontinentadmin() )
				  	<div class="form-group">
				  		<label class="col-md-4 col-form-label text-md-right">
				  			{{__('messages.permission')}}
				  		</label>
				  	</div>
				  	<div class="col-md-7 dtext-md-center" style="padding:auto;margin:auto;">
				  		<div class="text-md-left" id="permission">
					  	@foreach($user->permission as $row )
					  		<div class="form-check">
					  			<!--
					  			<input type="checkbox" class="form-check-input" id="exampleCheck1" name="permission" value="{{$row->id}}">
					  		-->
					  			<input type="hidden" name="addpermission[]" value="{{$row->permid}}">
					  			<button class="btn btn-danger" type="button" onclick="rm(this)">X</button>

					  			<label class="form-check-label" for="exampleCheck1">{{$row->permissionName->perm_name}}</label>
					  		</div>
					  	@endforeach
					  	
					  	</div>
					  	
					  	<button type="button" class="btn btn-primary" onclick="addpermission()">+</button>
					  	
					</div>
				@endif
				@if($user->permcontinentadmin())
					<div class="col-md-7 dtext-md-center" style="padding:auto;margin:auto;">
						{{__('messages.continent')}}
						<div id="permcontinent" class="pl-3">
							@foreach($user->permissionRegion()->whereNotNull('continentid')->get() as $row)
								<div>
									<input type="hidden" name="addcontinent[]" value="{{$row->continentid}}">
									<button class="btn btn-danger" type="button" onclick="rm(this)">X</button>
									{{$row->continent->name}}
								</div>
							@endforeach
						</div>
						<button class="btn btn-primary" type="button" onclick="addcontinent()">+</button>
					</div>
				@endif
				@if($user->permmoderator() )
				<div class=" pt-2 pb-2">

					<div class="col-md-7 dtext-md-center" style="padding:auto;margin:auto;">

						{{__('messages.country')}}
						<div id="permcountry" class="pl-3">
							@foreach($user->permissionRegion()->whereNotNull('countryid')->get() as $row)
								<div>
									<input type="hidden" name="addcountry[]" value="{{$row->countryid}}">
									<button class="btn btn-danger" type="button" onclick="rm(this)">X</button>
									{{$row->country->name}}
								</div>
							@endforeach
						</div>
						<button class="btn btn-primary" type="button" onclick="addcountry()">+</button>
					</div>
			  		
			  		<div class="col-md-7 dtext-md-center" style="padding:auto;margin:auto;">
			  			{{__('messages.language')}}
						<div id="languages" class="pl-3">
							@foreach($user->permissionLanguage as $row)
								<div>
									<input type="hidden" name="addlanguage[]" value="{{$row->languageid}}">
									<button class="btn btn-danger" type="button" onclick="rm(this)">X</button>
									{{$row->language->name}}
								</div>
							@endforeach
						</div>
						<button class="btn btn-primary" type="button" onclick="addlanguage()">+</button>
					</div>	
				</div>
				@endif
			  		
			  	
			  	<div style="text-align: center;">
				  	<a href="{{ url()->previous() }}" class="btn btn-light border col-lg-5"> {{__('messages.cancel')}}</a>
					<input class="btn btn-primary col-lg-5" type="submit" name="submit" value="{{__('messages.save')}}">
			  	</div>
			  </div>
			</div>
			</form>

		</div>
	</div>
</div>
@endsection