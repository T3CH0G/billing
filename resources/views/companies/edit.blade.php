@extends('layouts.app')

@section('content')
<div class="container">
    @if (Auth::guest())
    <hr>
    <h1> Please login </h1>
    <hr>

    @else

    <h1>Editing "{{ $company->name }}"</h1>
    <p class="lead">Edit and save this company below, or <a href="{{ route('companies.index') }}">go back to all companies.</a></p>
    <hr>

    @include('partials.alerts.errors')

    {!! Form::model($company, [
        'method' => 'PATCH',
        'route' => ['companies.update', $company
       ->id],
       'files' => true,
    ]) !!}


    <div class="form-group">
        {!! Form::label('name', 'name:', ['class' => 'control-label']) !!}
        {!! Form::textarea('name', null, ['class' => 'form-control']) !!}
    <h2>Current Logo:</h2> 
  <div class="logo">
    <img src="/images/{{$company->id}}.png">
  </div>
        {!! Form::label('image', 'Logo Image:', ['class' => 'control-label']) !!}
        {!! Form::file('image', null) !!}
    </div>

    {!! Form::submit('Update company', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
    @endif
</div>
@stop
