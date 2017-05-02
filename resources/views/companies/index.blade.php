@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
	@if (Auth::guest())
	<hr>
	<h1> Please login </h1>
	<hr>

	@else

	<h2> companies </h2>
	<hr>

	@foreach($companies as $company)	
	<h3>{{ $company->name }}</h3>
	<p>
	    <a href="{{ route('companies.show', $company->id) }}" class="btn btn-info">View company</a>
	    <a href="{{ route('companies.edit', $company->id) }}">edit</a>
	</p>
	<hr>

@endforeach
@endif
	</div>
</div>
@stop