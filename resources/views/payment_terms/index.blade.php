@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
	@if (Auth::guest())
	<hr>
	<h1> Please login </h1>
	<hr>
	@else
	<h2> Payment Terms </h2>
	<hr>
	@foreach($payment_terms as $payment_term)	
	<h4>{{ $payment_term->payment_term }}</h4>
	<p>
	    <a href="{{ route('payment_terms.show', $payment_term->id) }}" class="btn btn-info">View payment_term</a>
	    <a href="{{ route('payment_terms.edit', $payment_term->id) }}">edit</a>
	</p>
	<hr>

@endforeach
@endif
	</div>
</div>
@stop