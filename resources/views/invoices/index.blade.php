@extends('layouts.app')

@section('content')

@include('partials.alerts.errors')

@if (Auth::guest())
<hr>
<h1> Please login </h1>
<hr>

@else
<div class="container" id="page">
        <h1>{{$title}}</h1>
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

@endif
@endsection
