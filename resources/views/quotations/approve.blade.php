@extends('layouts.app')

@section('content')
<h3>Quotation QUO0007{{$quotation->quotation_id}} Approved!</h3>
<br>
@if($invoice=='null')
Click
<a href="/companies/{{$quotation->company_id}}" class="btn btn-primary">here to return to company view</a>
@else
Click
<a href="/invoices/{{$invoice->id}}" class="btn btn-primary">here to view newly generated invoice</a>
@endif

@stop