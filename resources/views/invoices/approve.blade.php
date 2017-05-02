@extends('layouts.app')

@section('content')
Invoice INV0008{{$invoice1->quotation_id}} status changed to Paid!
@if($invoice2=='null')
Click
<a href="/companies/{{$invoice1->company_id}}" class="btn btn-primary">here to return to company view</a>
@else
Click
<a href="/invoices/{{$invoice2->id}}" class="btn btn-primary">here to view newly generated remainder invoice</a>
@endif

@stop