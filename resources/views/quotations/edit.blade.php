@extends('layouts.app')

@section('content')

@if (Auth::guest())
<hr>
<h1> Please login </h1>
<hr>

@else
<h1>Editing {{ $quotation->quotation_id }}</h1>
<p class="lead">Edit and save this quotation below, or <a href="{{ route('quotations.index') }}">go back to all quotations.</a></p>
<hr>

@include('partials.alerts.errors')

{!! Form::model($quotation, [
    'method' => 'PATCH',
    'route' => ['quotations.update', $quotation
   ->id]
]) !!}


<div class="form-group">
    {!! Form::label('client_id', 'client:', ['class' => 'control-label']) !!}
    {!! Form::select('client_id', $clients, ['class' => 'form-control']) !!}
    <br>
    {!! Form::label('company_id', 'Select Company:', ['class' => 'control-label']) !!}
    {!! Form::select('company_id', $companies, ['class' => 'form-control']) !!}
    <br>
    {!! Form::label('subject', 'subject:', ['class' => 'control-label']) !!}
    {!! Form::textarea('subject', null, ['class' => 'form-control']) !!}
    {!! Form::hidden('quotation_id', $quotation->quotation_id,  ['class' => 'form-control']) !!}
    {!! Form::label('payment_type', 'Payment type:', ['class' => 'control-label']) !!}
    {!! Form::select('payment_type', array('Upfront 50%' => 'Upfront 50%', '60 days within live date'=>'60 days within live date','Monthly' => 'Monthly', 'Order' => 'Order'), $quotation->payment_type, ['class' => 'form-control']) !!}
    {!! Form::label('quotation_status', 'Quotation Status:', ['class' => 'control-label']) !!}
    {!! Form::select('quotation_status', array('Pending' => 'Pending', 'Approved'=>'Approved','Rejected' => 'Rejected'), $quotation->quotation_status, ['class' => 'form-control']) !!}
    <div class="input_fields_wrap">
        <div class="col-md-3">{!! Form::label('item', 'Item:', ['class' => 'control-label']) !!}</div>
        <div class="col-md-3">{!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}</div>
        <div class="col-md-2">{!! Form::label('cost', 'Cost:', ['class' => 'control-label']) !!}</div>
        <div class="col-md-2">{!! Form::label('quantity', 'Quantity:', ['class' => 'control-label']) !!}</div>
        <div class="col-md-3"><input type="text" name="item[0]" value="{{$quotation->item[0]}}"></div>
        <div class="col-md-3"><input type="text" name="description[0]" value="{{$quotation->description[0]}}"></div>
        <div class="col-md-2"><input type="text" name="cost[0]" value="{{$quotation->cost[0]}}"></div>
        <div class="col-md-2"><input type="text" name="quantity[0]" value="{{$quotation->quantity[0]}}"></div>
    @for($i = 1; $i <= $number-1; $i++)
        <div id="divs"><div class="col-md-3">{!! Form::label('item', 'Item:', ['class' => 'control-label']) !!}</div>
        <div class="col-md-3">{!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}</div>
        <div class="col-md-2">{!! Form::label('cost', 'Cost:', ['class' => 'control-label']) !!}</div>
        <div class="col-md-2">{!! Form::label('quantity', 'Quantity:', ['class' => 'control-label']) !!}</div></div>
        <div id="divs"><div class="col-md-3"><input type="text" name="item[]" value="{{$quotation->item[$i]}}"></div>
        <div class="col-md-3"><input type="text" name="description[]" value="{{$quotation->description[$i]}}"></div>
        <div class="col-md-2"><input type="text" name="cost[]" value="{{$quotation->cost[$i]}}"></div>
        <div class="col-md-2"><input type="text" name="quantity[]" value="{{$quotation->quantity[$i]}}"></div></div>
    @endfor
    <div class="col-md-2"><a href="#" id="rm" class="remove_field">Remove</a></div>
        <div class="col-md-2"><button class="add_field_button">Add More Fields</button></div>
    </div>
    <br>
    <div class="col-md-6">
        {!! Form::label('created_at', 'Date:', ['class' => 'control-label']) !!}
        {!! Form::date('created_at', \Carbon\Carbon::now())!!}
    </div>
    <div class="col-md-6">
        {!! Form::label('discount', 'Discount Percentage:', ['class' => 'control-label']) !!}
        {!! Form::number('discount', $quotation->discount, ['class' => 'form-control']) !!}
    </div>
    <br>

    <h3> Amount Paid </h3>
    {!! Form::label('amount_paid', 'Amount Paid if applicable(otherwise leave at 0):', ['class' => 'control-label']) !!}
    {!! Form::text('amount_paid', $quotation->amount_paid, ['class' => 'form-control']) !!}
</div>
<div class="col-md-12">
{!! Form::submit('Update quotation', ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}
<hr>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
 <script src="{{ asset('js/addfield.js') }}"></script>
@endif
@stop