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

	<h1>Add a New client</h1>
	<p class="lead">Add to your client list below.</p>
	{!! Form::open([
	    'route' => 'clients.store'
	]) !!}

	<div class="form-group">
	    {!! Form::label('name', 'Client Name:', ['class' => 'control-label']) !!}
	    {!! Form::textarea('name', null, ['class' => 'form-control']) !!}
	   	{!! Form::label('email', 'Client Email:', ['class' => 'control-label']) !!}
	    {!! Form::textarea('email', null, ['class' => 'form-control']) !!}
	    {!! Form::label('company_name', 'Company Name:', ['class' => 'control-label']) !!}
	    {!! Form::textarea('company_name', null, ['class' => 'form-control']) !!}
	    {!! Form::label('registration_number', 'Registration Number:', ['class' => 'control-label']) !!}
	    {!! Form::textarea('registration_number', null, ['class' => 'form-control']) !!}
	    {!! Form::label('address','Address:', ['class' => 'control-label']) !!}
	    {!! Form::textarea('address', null, ['class' => 'form-control']) !!}
	    {!! Form::label('country', 'Country(for currency conversion):', ['class' => 'control-label']) !!}
    	{!! Form::select('country', array('MYR' => 'MYR', 'SGD'=>'SGD'), 'MYR', ['class' => 'form-control']) !!}
    	{!! Form::hidden('user_id', 'test',  ['class' => 'form-control']) !!}
	</div>

	{!! Form::submit('Create New clients', ['class' => 'btn btn-primary']) !!}

	{!! Form::close() !!}
	<hr>
	</div>
</div>
@endif
@stop