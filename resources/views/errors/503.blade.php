@extends('view')
@section('includecontent')
<title>503 {{__('messages.error503')}}</title>
@endsection
@section('content')
<div class="mt-3 mb-5 text-center" style="padding: auto;margin: auto;padding-top: 100px; padding-bottom: 150px;">
	<h1>503</h1>
	<h4>{{__('messages.error503')}}</h4>
</div>
@endsection