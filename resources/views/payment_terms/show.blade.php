@extends('layouts.app')

@section('content')
<div class="container">
@if (Auth::guest())
<hr>
<h1> Please login </h1>
<hr>

@else

<h1> Payment_term View </h1>
<h2>Name:</h2> 
<p>{{ $payment_term->payment_term }}</p>
<h2>Invoice 1 Percentage: </h2> 
<p>{{ $payment_term->invoice_1 }}</p>
<h2>Invoice 2 Percentage:</h2> 
<p>{{ $payment_term->invoice_2}}</p>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('payment_terms.index') }}" class="btn btn-info">Back to all payment_terms</a>
        <a href="{{ route('payment_terms.edit', $payment_term->id) }}" class="btn btn-primary">Edit payment_term</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['payment_terms.destroy', $payment_term->id]
        ]) !!}
            {!! Form::submit('Delete this payment_term?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>
<hr>

@endif
</div>
@stop