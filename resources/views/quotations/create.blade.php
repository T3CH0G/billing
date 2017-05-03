@extends('layouts.app')
@section('content')
@include('partials.alerts.errors')
<div class="container">
    @if (Auth::guest())
        <hr>
        <h1> Please login </h1>
        <hr>
    @elseif ($clients == [])
        <hr>
        <h1> Please add a client before proceeding. </h1>
            <a href="{{ route('clients.create') }}" class="btn btn-primary">Create New Client</a>
        <hr>
    @else
        <h1>Add a New Quotation</h1>
        <p class="lead">Add to your quotation list below.</p>
        {!! Form::open(['route' => 'quotations.store']) !!}
        <div class="form-group">
            {!! Form::label('client_id', 'client:', ['class' => 'control-label']) !!}
            {!! Form::select('client_id', $clients, ['class' => 'form-control']) !!}
            <br>
            {!! Form::label('company_id', 'Company:', ['class' => 'control-label']) !!}
            {!! Form::hidden('company_id', $company->id, ['class' => 'form-control']) !!}
            <p> {{$company->name}}</p>
            {!! Form::label('subject', 'subject:', ['class' => 'control-label']) !!}
            {!! Form::text('subject', null, ['class' => 'form-control']) !!}
            {!! Form::hidden('quotation_id', 'test',  ['class' => 'form-control']) !!}
            {!! Form::hidden('subtotal', 'test',  ['class' => 'form-control']) !!}
            {!! Form::hidden('user_id', 'test',  ['class' => 'form-control']) !!}
            {!! Form::hidden('total', 'test',  ['class' => 'form-control']) !!}
            {!! Form::label('payment_type', 'Payment type:', ['class' => 'control-label']) !!}
            <p>Choose a payment type</p>
            {!! Form::select('payment_type', $payments, 'Upfront 50%', ['class' => 'form-control']) !!}
            {!! Form::label('quotation_status', 'Quotation Status:', ['class' => 'control-label']) !!}
            {!! Form::select('quotation_status', array('Pending' => 'Pending', 'Approved'=>'Approved','Rejected' => 'Rejected'), 'Pending', ['class' => 'form-control']) !!}
                <div class="input_fields_wrap">
                    <div class="row">
                        <div class="col-md-3">{!! Form::label('item', 'Item:', ['class' => 'control-label']) !!}</div>
                        <div class="col-md-3">{!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}</div>
                        <div class="col-md-2">{!! Form::label('cost', 'Cost:', ['class' => 'control-label']) !!}</div>
                        <div class="col-md-2">{!! Form::label('quantity', 'Quantity:', ['class' => 'control-label']) !!}</div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><input type="text" name="item[]"></div>
                        <div class="col-md-3"><input type="text" name="description[]"></div>
                        <div class="col-md-2"><input type="text" name="cost[]"></div>
                        <div class="col-md-2"><input type="text" name="quantity[]"></div>
                        <div class="col-md-2"><button class="add_field_button">Add More Fields</button></div>
                    </div>
                </div>
                <br>
                <div class="col-md-6">
                    {!! Form::label('created_at', 'Date:', ['class' => 'control-label']) !!}
                    {!! Form::date('created_at', \Carbon\Carbon::now())!!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('discount', 'Discount Percentage:', ['class' => 'control-label']) !!}
                    {!! Form::number('discount', 0, ['class' => 'form-control']) !!}
                </div>
                <br>
                <div class="col-md-12">
                    <h3> Amount Paid </h3>
                    {!! Form::label('amount_paid', 'Amount Paid if applicable(otherwise leave at 0):', ['class' => 'control-label']) !!}
                    {!! Form::text('amount_paid', 0, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-12">
                    <h3> Currency </h3>
                    {!! Form::label('currency', 'Currency:', ['class' => 'control-label']) !!}
                    {!! Form::select('currency', array('SGD' => 'SGD', 'MYR'=>'MYR'), 'MYR', ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-12">
                    {!! Form::submit('Create New quotations', ['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
            <hr>
        </div>
    @endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="{{ asset('js/addfield.js') }}"></script>
@stop