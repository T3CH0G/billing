@extends('layouts.app')

@section('content')
<div class="container">
@if (Auth::guest())
<hr>
<h1> Please login </h1>
<hr>

@else

<h1> Client View </h1>
<h2>Name:</h2> 
<p>{{ $client->name }}</p>
<h2>Company: </h2> 
<p>{{ $client->company_name }}</p>
<h2>Registration Number</h2> 
<p>{{ $client->registration_number }}</p>
<h2> Address: </h2> 
<p>{{ $client->address }}</p>
<h2> Country: </h2> 
<p>{{ $client->country }}</p>
<h2> Email: </h2> 
<p>{{ $client->email }}</p>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('clients.index') }}" class="btn btn-info">Back to all clients</a>
        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary">Edit client</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['clients.destroy', $client->id]
        ]) !!}
            {!! Form::submit('Delete this client?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>
<hr>

<div class="container" id="page">
<h3>Client Breakdown</h3>
<h4>Total Amount Paid:</h4> {{$amount_paid}}
<h4>Total Amount Owed:</h4> {{$amount_owed}}
</div>

<hr>

<div class="container" id="page">
        <h1>Quotations of {{$client->name}} </h1>
        <br/>
        
                <!-- Quotation Loop !-->
     @foreach ($quotations as $quotation)
        <span class="info">
        {{ $quotation->subject }} / {{ $quotation->created_at->toDatestring() }} / Paid: RM{{$quotation->amount_paid }}
        @if($quotation->quotation_status == 'Approved')
        </span> / <span style="text-transform:capitalize; font-weight:bold;">
                                           <span style="color:#330099">approved</span>
                                           </span>
        @elseif($quotation->quotation_status == 'Pending')
        </span> / <span style="text-transform:capitalize; font-weight:bold;">
                                           <span style="color:red">pending</span>
                                           </span>
        @elseif($quotation->quotation_status == 'Rejected')
        </span> / <span style="text-transform:capitalize; font-weight:bold;">
                   rejected                   </span>
        @endif

        <p>
        <a href="{{ route('quotations.show', $quotation->id) }}" class="btn btn-info">View quotation</a>
        </p>
      @endforeach
        
    </div>
    <div class="row">
    <div class="col-md-4">
    <a href="{{ route('quotations.create') }}" class="btn btn-info">Create New Quotation</a>
    </div>
    <hr>


<div class="container" id="page">
        <h1>Invoices of {{$client->name}}</h1>
        <br/>
        
                <!-- invoice Loop !-->
     @foreach ($invoices as $invoice)
        <span class="info">
        {{ $invoice->title }} / {{ $invoice->created_at->toDatestring() }} 
        @if($invoice->invoice_status == 'Pending')
        </span> / <span style="text-transform:capitalize; font-weight:bold;">
                                           <span style="color:red">{{$invoice->payment_type}} Pending</span>
                                           </span>
        @elseif($invoice->invoice_status == 'Paid')
        </span> / <span style="text-transform:capitalize; font-weight:bold;">
                                           {{$invoice->payment_type}} Paid                                           </span>
        @endif

        <p>
        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info">View invoice</a>
        </p>
      @endforeach
        
    </div>
    <a href="{{ route('invoices.create') }}" class="btn btn-info">Create New Invoice</a>
<hr>
@endif
</div>
@stop