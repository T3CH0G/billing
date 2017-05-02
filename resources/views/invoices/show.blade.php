@extends('layouts.app')

@section('content')

            <div class="container" id="page">
              <div class="row bg-header">
                INVOICE
              </div>
              <div class="row">
                <div class="col-xs-7">
                                    <div class="from">
                    <h1>{{$company->name}}</h1>
                    <p>
                      {{$company->address1}}<br>
                      {{$company->address2}}<br>
                      {{$company->address3}}<br>
                      {{$company->address4}}<br>
                      {{$company->address5}}
                  </p>
                  </div>
                                    
                  <div class="to">
                     <h1>{{$client->name}}</h1>
                      @if($client->address==null)
                                <p>         </p>
                      @else
                                            <p>
                       {{$client->address}}       </p>
                    @endif
                  </div>
                </div>
                <div class="col-xs-5 right">
                  <div class="logo">
                    <img src="/images/{{$company->imageName}}">
                  </div>

                                    <div class="quotation_info">
                    <table id="meta">
                      <tr>
                        <td class="left meta-head">Invoice #</td>
                        <td class="right">{{'INV0008'.$quotation->quotation_id}}                     </td>
                      </tr>
                                            <tr>
                        <td class="left meta-head">PO #</td>
                        <td class="right">{{$invoice->purchase_order}}</td>
                      </tr>
                                            <tr>
                        <td class="left meta-head">Date</td>
                        <td class="right">{{$invoice->created_at}}</td>
                      </tr>
                      <tr>
                        <td class="left meta-head">Subject</td>
                        <td class="right">{{$invoice->title}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                    <div class="row data">
                        <table id="items" cellpadding="0" cellspacing="0">     
                          <tr>
                              <th width="20%">Item</th>
                              <th width="40%">Description</th>
                              <th width="15%">Unit Cost</th>
                              <th widt="10%">Quantity</th>
                              <th width="15%">Price</th>
                          </tr>
                          <!-- Content Here !-->
                     @for($i = 0; $i < $number; $i++)
                            <tr class="item-row">
                              <td>{{ $quotation->item[$i] }}</td>
                              <td>{{ $quotation->description[$i] }}</td>
                              <td style="text-align:center;">{{ $quotation->cost[$i]}}</td>
                              <td style="text-align:center">{{ $quotation->quantity[$i] }}</td>
                              <td style="padding-left:10px;"><span class="price">{{ $quotation->cost[$i] * $quotation->quantity[$i]}}</span></td>
                          </tr> 
                                            <tr>
                          <td colspan="5" height="40" class="blank"></td>
                        </tr>
                      @endfor
                  <!-- End Content here !-->            
                          <tr>
                              <td colspan="2" class="blank" style="border-top:1px solid #000000"></td>
                              <td colspan="2" class="total-line">Subtotal</td>
                              <td class="total-value"><div id="subtotal">{{$invoice->subtotal}}</div></td>
                          </tr>
                          <!-- If there is a discount !-->
                                                    <tr>
                              <td colspan="2" class="blank"> </td>
                              <td colspan="2" class="total-line">Discount</td>
                              <td class="total-value">{{$quotation->discount}}</td>
                          </tr>
                                                    <!-- End Discount!-->

                           <!-- If initial payment 50% !-->

                                                    <tr>
                              <td colspan="2" class="blank"> </td>
                              <td colspan="2" class="total-line">Amount Due ({{$invoice->payment_type}})</td>
                              <td class="total-value">{{$amount_due}}</td>
                                                          
                          </tr>
                                                    <!-- End Initial !-->

                           <!-- If remainder payment 50% !-->

                                                    <!-- End Initial !-->
                          <tr>

                              <td colspan="2" class="blank"> </td>
                              <td colspan="2" class="total-line balance">Total</td>
                              <td class="total-value balance"><div id="total">{{$invoice->total}}</div></td>

                          </tr>

                          <!-- SGD Total !-->
                                                     <!-- End SGD Total !-->
                        
                        </table>
                    </div>
                    <div class="row" id="terms" style="text-align:center">
                       <h5>Payment Method</h5>
                                             <p>All payments must only be in the form of bank-in or cheque payable to <strong>The Techy Hub Sdn Bhd</strong><br/>
Maybank Malaysia Bank Account - <strong>514123637616</strong></p>
                                          </div>
              </div>
              <div class="row" style="margin-top:100px; text-align:center; padding-bottom:20px;">
                <a href="javascript:window.print()" class="print-button">Print this</a>
              </div>
            </div>
            <div class="row" style="text-align:center;"><h3>Invoice Status: {{$invoice->invoice_status}}</h3>
            </div>

                <div class="row">
    <div class="col-md-6">
        <a href="{{ route('invoices.index') }}" class="btn btn-info">Back to all invoices</a>
        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-primary">Edit invoice</a>
        @if($invoice->invoice_status == 'Pending')
        <a href="/approveinvoice/{{$invoice->id}}" class="btn btn-primary">Change Invoice to Paid</a>
        @endif
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['invoices.destroy', $invoice->id]
        ]) !!}
            {!! Form::submit('Delete this invoice?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>


@stop