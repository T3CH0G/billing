@extends('layouts.app')

@section('content')

   <div class="container" id="page">
        <div class="row bg-header">
            QUOTATION
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
                            <td class="left meta-head">Quotation #</td>
                            <td class="right">{{ 'QUO0007'.$quotation->quotation_id }}</td>
                        </tr>
                        <tr>
                            <td class="left meta-head">Date</td>
                            <td class="right">{{ $quotation->created_at->toDateString()}}</td>
                        </tr>
              <tr>
                <td class="left meta-head">Subject</td>
                <td class="right">{{ $quotation->subject }}</td>
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
                      <td class="total-value"><div id="subtotal">{{$quotation->subtotal}}</div></td>
                  </tr>
                  <!-- If there is a discount !-->
                                    <tr>
                      <td colspan="2" class="blank"> </td>
                      <td colspan="2" class="total-line">Discount</td>
                      <td class="total-value">{{$quotation->discount}} %</td>
                  </tr>
                                    <!-- End Discount!-->
                  <tr>

                      <td colspan="2" class="blank"> </td>
                      <td colspan="2" class="total-line balance">Total</td>
                      <td class="total-value balance"><div id="total">{{$quotation->total}}</div></td>
                  </tr>
                  <!-- SGD Total !-->

                                    <!-- End SGD Total !-->
                
                </table>
            </div>
            <div class="row" id="terms" style="text-align:center">
               <h5>Payment Terms</h5>
                               <p>{{ $quotation->payment_type }}</p>
                               <div class="small-terms" style="font-size:12px; font-style:italic">
                  *Quotations are valid for 14 days from the date of the quotation ({{ $quotation->created_at->toDateString() }}).<br/>
              </div>
            </div>

            <div class="row" id="signature">
              <div class="container">
                <div class="col-xs-4" style="text-align:right; padding-right:10px">
                    Name: ......................
                </div>
                <div class="col-xs-4" style="text-align:center; padding:0 10px;">
                    Signed by: ......................
                </div>
                <div class="col-xs-4" style="text-align:left; padding-left:10px">
                    Date : ......................
                </div>
            </div>
            </div>
        </div>
      
        <div class="row" style="margin-top:40px; text-align:center; padding-bottom:20px;">
            <a href="javascript:window.print()" class="print-button">Print this</a>
        </div>
    </div>
              <div class="row" style="text-align:center;"><h3>Quotation Status: {{$quotation->quotation_status}}</h3>
            </div>
    <hr>

    <div class="row">
    <div class="col-md-6">
        <a href="{{ route('quotations.index') }}" class="btn btn-info">Back to all quotations</a>
        <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn btn-primary">Edit quotation</a>
        @if($quotation->quotation_status == 'Pending')
        <a href="/approvequotation/{{$quotation->id}}" class="btn btn-primary">Approve quotation</a>
        @endif
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['quotations.destroy', $quotation->id]
        ]) !!}
            {!! Form::submit('Delete this quotation?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop