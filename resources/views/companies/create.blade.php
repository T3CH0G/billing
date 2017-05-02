@extends('layouts.app')
@section('content')
@include('partials.alerts.errors')
<div class="container">
	<div class="row">
		@if (Auth::guest())
			<hr>
			<h1> Please login </h1>
			<hr>
		@else
			<h1>Add a New company</h1>
			<p class="lead">Add to your company list below.</p>
			{!! Form::open(
    			array(
        		'route' => 'companies.store', 
        		'class' => 'form', 
        		'files' => true)) !!}
			<div class="form-group">
			    {!! Form::label('name', 'name:', ['class' => 'control-label']) !!}
			    {!! Form::text('name', null, ['class' => 'form-control']) !!}
			    {!! Form::label('image', 'Logo Image:', ['class' => 'control-label']) !!}
		    	{!! Form::file('image', null) !!}
		    	{!! Form::hidden('user_id', 'test',  ['class' => 'form-control']) !!}
		    	{!! Form::hidden('imageName', 'test',  ['class' => 'form-control']) !!}
		    	{!! Form::label('address1', 'Address:', ['class' => 'control-label']) !!}
			    {!! Form::text('address1', null, ['class' => 'form-control']) !!}
			    {!! Form::text('address2', null, ['class' => 'form-control']) !!}
			    {!! Form::text('address3', null, ['class' => 'form-control']) !!}
			    {!! Form::text('address4', null, ['class' => 'form-control']) !!}
			    {!! Form::text('address5', null, ['class' => 'form-control']) !!}
			    {!! Form::label('registration_number', 'Registration Number:', ['class' => 'control-label']) !!}
			    {!! Form::text('registration_number', null, ['class' => 'form-control']) !!}
			    {!! Form::label('bank_account_MY', 'Malaysian Bank Account(leave blank if none):', ['class' => 'control-label']) !!}
			    {!! Form::text('bank_account_MY', null, ['class' => 'form-control']) !!}
			   	{!! Form::label('bank_account_SG', 'Singaporean Bank Account(leave blank if none):', ['class' => 'control-label']) !!}
			    {!! Form::text('bank_account_SG', null, ['class' => 'form-control']) !!}
			    {!! Form::label('GST', 'GST(yes if applicable):', ['class' => 'control-label']) !!}
			    {!! Form::select('GST', array('Yes'=>'Yes', 'No' => 'No'),'Yes', ['class' => 'form-control']) !!}
			</div>
			{!! Form::submit('Create New Company', ['class' => 'btn btn-primary']) !!}
			{!! Form::close() !!}
			<hr>
		@endif
	</div>
</div>
@stop