@extends('layouts.app')
@section('content')
<div class="container">
@if (Auth::guest())
<hr>
<h1> Please login </h1>
<hr>

@else

<h1> Company View </h1>
<h2>Name:</h2> 
<p>{{ $company->name }}</p>
<h2>Logo</h2> 
  <div class="logo">
    <img src="/images/{{$company->imageName}}">
  </div>
<h2>Address: </h2>
<p>
{{$company->address1}}<br>
{{$company->address2}}<br>
{{$company->address3}}<br>
{{$company->address4}}<br>
{{$company->address5}}
</p>
<h2>Registration Number: </h2> 
<p>{{ $company->registration_number}}</p>
<h2>Malaysian bank account number: </h2> 
<p>{{ $company->bank_account_MY}}</p>
<h2>Singaporean bank account number: </h2> 
<p>{{ $company->bank_account_SG}}</p>
<h2>GST Applicable?: </h2> 
<p>{{ $company->GST}}</p>
<h2>Created by: </h2> 
<p>{{ $user->name}}</p>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('companies.index') }}" class="btn btn-info">Back to all companies</a>
        <a href="/companies/sales/{{$company->id}}" class="btn btn-info">View current month breakdown</a>
        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">Edit company</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['companies.destroy', $company->id]
        ]) !!}
            {!! Form::submit('Delete this company?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

<hr>

<div class="container" id="page">
  <h1>{{$company->name}} Payment Terms</h1>
      @if(is_null($payment_terms))
        <p> no payment terms yet </p>
        <a href="/payment_terms/create/{{$company->id}}" class="btn btn-info">Create new payment term</a>
      @else
        @foreach ($payment_terms as $term)
          {{$term->payment_term}}
          <p>
          <a href="{{ route('payment_terms.show', $term->id) }}" class="btn btn-info">View details</a>
          </p>
        @endforeach
      @endif 
</div>
<div class="row">
  <div class="col-md-4">
    <a href="/payment_terms/create/{{$company->id}}" class="btn btn-info">Create new payment term</a>
  </div>
</div>
<hr>

<div class="container" id="page">
        <h1>{{$company->name}} Quotations</h1>
        <br/>
        
                <!-- Quotation Loop !-->
     @foreach ($quotations as $quotation)
        <span class="info">
        {{ $quotation->subject }} / {{ $quotation->created_at->toDatestring() }} /Total: RM{{$quotation->total}}
        @if($quotation->quotation_status == 'Pending') Paid: RM{{$quotation->amount_paid }}/
        @endif
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
      <a href="/quotations/create/{{$company->id}}" class="btn btn-info">Create New Quotation</a>
      </div>
    </div>
    <hr>
</div>


<div class="container" id="page">
        <h1>{{$company->name}} Invoices</h1>
        <br/>
        
                <!-- invoice Loop !-->
     @foreach ($invoices as $invoice)
        <span class="info">
        {{ $invoice->title }} / {{ $invoice->created_at->toDatestring() }}/Total: RM{{$invoice->total}}
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
    <a href="{{ route('invoices.create') }}" class="btn btn-info">Create New Quotation</a>
</div>
<hr>



@endif
</div>
@stop