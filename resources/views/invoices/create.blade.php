@extends('layouts.app')

@section('content')

@include('partials.alerts.errors')

@if (Auth::guest())
<hr>
<h1> Please login </h1>
<hr>

@elseif ($clients == '' || $quotations == '')

<hr>
<h1> Please add a client or quotation before proceeding. </h1>
<hr>

@else

<h1>Add a New invoice</h1>
<p class="lead">Add to your invoice list below.</p>
{!! Form::open([
    'route' => 'invoices.store'
]) !!}

<div class="form-group">
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::textarea('title', null, ['class' => 'form-control']) !!}
    {!! Form::hidden('client_id', 'test',  ['class' => 'form-control']) !!}
    {!! Form::hidden('company_id', 'test',  ['class' => 'form-control']) !!}
    {!! Form::hidden('user_id', 'test',  ['class' => 'form-control']) !!}
    <br>
    
    {!! Form::label('created_at', 'Date:', ['class' => 'control-label']) !!}
    {!! Form::date('created_at', \Carbon\Carbon::now())!!}

    {!! Form::label('invoice_status', 'Invoice status:', ['class' => 'control-label']) !!}

    {!! Form::select('invoice_status', array('Paid' => 'Paid', 'Pending'=>'Pending'), 'Paid', ['class' => 'form-control']) !!}

    {!! Form::label('payment_type', 'Payment type:', ['class' => 'control-label']) !!}

    {!! Form::select('payment_type', array('Initial 50%' => 'Initial 50%', 'Remainder 50%'=>'Remainder 50%','Full Payment' => 'Full Payment', 'Purchase Order' => 'Purchase Order', 'Twenty Percent - 20%' => 'Twenty Percent - 20%', 'Eighty Percent - 80%' => 'Eighty Percent - 80%'), 'Upfront 50%', ['class' => 'form-control']) !!}

    {!! Form::label('quotation_id', 'Choose the relevant quotation:', ['class' => 'control-label']) !!}
    {!! Form::select('quotation_id', $quotations, ['class' => 'form-control']) !!}

    <br>

    {!! Form::label('purchase_order', 'Purchase Order Number:', ['class' => 'control-label']) !!}
    {!! Form::textarea('purchase_order', null, ['class' => 'form-control']) !!}

</div>
<div class="col-md-12">
{!! Form::submit('Create New invoices', ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}
<hr>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
@endif
@stop