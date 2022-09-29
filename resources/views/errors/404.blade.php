@extends('view')
@section('includecontent')
<title>404 {{__('messages.pagenotfound')}}</title>
@endsection
@section('content')
<div class="mt-3 mb-5 text-center" style="padding: auto;margin: auto;padding-top: 100px; padding-bottom: 150px;">
	<h1>404</h1>
	<h4>{{__('messages.pagenotfound')}}</h4>
</div>
@endsection