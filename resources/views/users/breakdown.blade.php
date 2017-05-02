@extends('layouts.app')

@section('content')
<h2>{{ $user->name }}'s Breakdown for this month</h2>
<hr>
<h3>Potential Sales: {{$potential_sales}}</h3>

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

<h3>Real Sales: {{$real_sales}}</h3>
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
<hr>
<h3>Email</h3>
<a href="/mail" class="btn btn-primary">Click here to send a full user report for this month to your email</a>
<h3>Automatic Breakdown Email Scheduling</h3>
<h4> Choose frequency of breakdown email sent</h4>
<h4> Current Frequency: {{$user->email_frequency}}</h4>
    {!! Form::model($user, [
        'method' => 'PATCH',
        'route' => ['users.update', $user
       ->id]
    ]) !!}


    <div class="form-group">
        {!! Form::label('email_frequnecy', 'Update Frequency:', ['class' => 'control-label']) !!}
        {!! Form::select('email_frequency', array('Every Minute'=>'Every Minute','Daily' => 'Daily', 'Weekly'=>'Weekly','Monthly' => 'Monthly'),'Monthly', ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}
@stop