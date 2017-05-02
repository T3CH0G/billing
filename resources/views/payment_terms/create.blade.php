@extends('layouts.app')

@section('content')


<div class="container">
	<div class="row">
	@include('partials.alerts.errors')
	@if (Auth::guest())
	<hr>
	<h1> Please login </h1>
	<hr>

	@else

	<h1>Add a New Payment Term for {{$company->name}}</h1>
	<p class="lead">Add to your term list below.</p>
	{!! Form::open([
	    'route' => 'payment_terms.store'
	]) !!}

	<div class="form-group">
	    {!! Form::label('payment_term', 'New Payment Term Name:', ['class' => 'control-label']) !!}
	    {!! Form::textarea('payment_term', null, ['class' => 'form-control']) !!}
	    {!! Form::label('invoice_1', 'Invoice 1 Percentage:', ['class' => 'control-label']) !!}
	    {!! Form::text('invoice_1', null, ['class' => 'form-control']) !!}
	    {!! Form::label('invoice_2', 'Invoice 2 Percentage:', ['class' => 'control-label']) !!}
	    {!! Form::text('invoice_2', null, ['class' => 'form-control']) !!}
    	{!! Form::hidden('company_id', $company->id ,  ['class' => 'form-control']) !!}
	</div>

	{!! Form::submit('Create New Payment Term', ['class' => 'btn btn-primary']) !!}

	{!! Form::close() !!}
	<hr>
	</div>
</div>
@endif
@stop