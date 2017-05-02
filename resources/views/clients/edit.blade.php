@extends('layouts.app')

@section('content')
<div class="container">
    @if (Auth::guest())
    <hr>
    <h1> Please login </h1>
    <hr>

    @else

    <h1>Editing "{{ $client->name }}"</h1>
    <p class="lead">Edit and save this client below, or <a href="{{ route('clients.index') }}">go back to all clients.</a></p>
    <hr>

    @include('partials.alerts.errors')

    {!! Form::model($client, [
        'method' => 'PATCH',
        'route' => ['clients.update', $client
       ->id]
    ]) !!}


    <div class="form-group">
        {!! Form::label('name', 'name:', ['class' => 'control-label']) !!}
        {!! Form::textarea('name', null, ['class' => 'form-control']) !!}
        {!! Form::label('email', 'Client Email:', ['class' => 'control-label']) !!}
        {!! Form::textarea('email', null, ['class' => 'form-control']) !!}
        {!! Form::label('company_name', 'company_name:', ['class' => 'control-label']) !!}
        {!! Form::textarea('company_name', null, ['class' => 'form-control']) !!}
        {!! Form::label('registration_number', 'registration_number:', ['class' => 'control-label']) !!}
        {!! Form::textarea('registration_number', null, ['class' => 'form-control']) !!}
        {!! Form::label('address', 'address:', ['class' => 'control-label']) !!}
        {!! Form::textarea('address', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Update client', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
    @endif
</div>
@stop
