@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
	@if (Auth::guest())
	<hr>
	<h1> Please login </h1>
	<hr>

	@else

	<h2> Clients </h2>
	<hr>

	@foreach($clients as $client)	
	<h3>{{ $client->name }}</h3>
	<h4>{{ $client->company_name }} </h4>
	<p>
	    <a href="{{ route('clients.show', $client->id) }}" class="btn btn-info">View client</a>
	    <a href="{{ route('clients.edit', $client->id) }}">edit</a>
	</p>
	<hr>

@endforeach
@endif
	</div>
</div>
@stop