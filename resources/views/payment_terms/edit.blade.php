@extends('layouts.app')

@section('content')
<div class="container">
    @if (Auth::guest())
    <hr>
    <h1> Please login </h1>
    <hr>

    @else

    <h1>Editing "{{ $payment_term->payment_term }}"</h1>
    <p class="lead">Edit and save this payment_term below, or <a href="{{ route('payment_terms.index') }}">go back to all payment_terms.</a></p>
    <hr>

    @include('partials.alerts.errors')

    {!! Form::model($payment_term, [
        'method' => 'PATCH',
        'route' => ['payment_terms.update', $payment_term
       ->id]
    ]) !!}


    <div class="form-group">
        {!! Form::label('payment_term', 'New Payment Term Name:', ['class' => 'control-label']) !!}
        {!! Form::textarea('payment_term', null, ['class' => 'form-control']) !!}
        {!! Form::label('invoice_1', 'Invoice 1 Percentage:', ['class' => 'control-label']) !!}
        {!! Form::text('invoice_1', null, ['class' => 'form-control']) !!}
        {!! Form::label('invoice_2', 'Invoice 2 Percentage:', ['class' => 'control-label']) !!}
        {!! Form::text('invoice_2', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Update payment_term', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
    @endif
</div>
@stop
