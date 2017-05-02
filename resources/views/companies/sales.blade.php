@extends('layouts.app')

@section('content')
<h2>{{ $company->name }}'s Breakdown for this month</h2>
<h2>Logo</h2> 
  <div class="logo">
    <img src="/images/{{$company->imageName}}">
  </div>
<h2>Created by: </h2> 
<p>{{ $user->name}}</p>
<hr>
<h3>Real Sales:</h3>
<p>Total: {{$real_sales}}</p>
@foreach ($invoices as $invoice)
        <span class="info">
        {{ $invoice->title }} / {{ $invoice->created_at }} 
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
<h3>Potential Sales:</h3>
<p>Total: {{$potential_sales}}</p>
     @foreach ($quotations as $quotation)
        <span class="info">
        {{ $quotation->subject }} / {{ $quotation->created_at }} / Paid: RM{{$quotation->amount_paid }}
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

@stop