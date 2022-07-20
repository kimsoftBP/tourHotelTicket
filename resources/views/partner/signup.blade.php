@extends('view')
@section('includecontent')
<script type="text/javascript">
    function categoryChange(text){
        console.log("test");
        if(text=="bus"){
            $("#companydata").show();
        }else{
            $("#companydata").hide();
        }
    }
</script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('messages.register') }}</div>
                {{--
    @if($errors->any())
        <div class="alert alert-danger">
        {{ implode('', $errors->all(':message')) }}
        </div>
    @endif
    --}}
                <div class="card-body">
                    <form method="POST" action="{{ route('partnersignup',app()->getLocale()) }}">
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
                                <select class="form-control @error('country') is-invalid @enderror" name="country">
                                    <option></option>
                                    @foreach($data['country'] as $country)
                                        <option value="{{$country->id}}" {{old('country')==$country->id ? 'selected':''}} >{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-md-4 col-form-label text-md-right">{{__('messages.city')}}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="city" value="{{old('city')}}">
                            </div>
                        </div>
                        <div class="form-group row justify-content-center d-flex">
                            @foreach($data['p_list'] as $row)
                            <div class="mr-4">
                                <input type="radio"   name="category" class="form-check-input" id="{{$row}}" value="{{$row}}" {{old('category')==$row ? 'checked':''}}>
                                <label for="{{$row}}" class="form-check-label">{{__('messages.'.$row)}}</label>
                            </div>
                            @endforeach
                            @error('category')
                                <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group row" id="companydata" >
                            <label class="col-form-label col-md-4 text-md-right">{{__('messages.companyName')}}</label>
                            <div class="col-md-6">
                                <input type="text" name="companyName" class="form-control @error('companyName') is-invalid @enderror">
                                @error('companyName')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-form-label col-md-4 text-md-right">{{__('messages.postCode')}}</label>
                            <div class="col-md-6">
                                <input type="text" name="postcode" class="form-control @error('postcode') is-invalid @enderror">
                                @error('postcode')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-form-label col-md-4 text-md-right">{{__('messages.address')}}</label>
                            <div class="col-md-6">
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror">
                                @error('address')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <label class="col-form-label col-md-4 text-md-right">{{__('messages.taxNumber')}}</label>
                            <div class="col-md-6">
                                <input type="text" name="taxNumber" class="form-control @error('taxNumber') is-invalid @enderror">
                                @error('taxNumber')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gdpr" class="col-md-4 col-form-label text-md-right">{{__('messages.acceptgdpr')}}</label>
                            <div class="col-md-6 ">
                                <input type="checkbox" name="acceptgdpr" class="@error('acceptgdpr') is-invalid @enderror" value="1" >
                                    @error('acceptgdpr')
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            {{__('messages.bypressingacceptserviceagrement')}}
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('messages.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
