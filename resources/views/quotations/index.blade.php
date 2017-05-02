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

@endif
@endsection
