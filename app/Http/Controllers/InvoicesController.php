<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Payment_term;
use App\Company;
use App\Invoice;
use App\Quotation;
use App\Client;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        $title = "All Invoices";
        return view('invoices.index',compact('invoices','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Quotations = Quotation::all();
        $q = [];
        foreach ($Quotations as $Quotation)
        {
            $q[$Quotation->quotation_id] = $Quotation->subject;
        }
        $quotations=$q;
        return view('invoices.create',compact('quotations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'quotation_id' => 'required',
        'title' => 'required',
        'payment_type' => 'required',
        'invoice_status' => 'required',
        'created_at' => 'required',
        'company_id'=>'required',
        'client_id'=>'required',
        'subtotal'=>'required',
        'total'=>'required',
        'user_id'=>'required'
        ]);
        $input = $request->all();
        $quotation=Quotation::where('quotation_id', $input['quotation_id'])->get();
        $quotation=$quotation[0];
        $quotation['item']=unserialize($quotation['item']);
        $quotation['description']=unserialize($quotation['description']);
        $quotation['cost']=unserialize($quotation['cost']);
        $quotation['quantity']=unserialize($quotation['quantity']);
        $number=count($quotation['item']);
        $total = 0;
        $discount = $quotation['discount'];
        for($i = 0; $i < $number; $i++)
        {
            $total = $total + $quotation->cost[$i]*$quotation->quantity[$i];
        }
        $subtotal=$total;
        $total=$total*((100-$discount)/100);
        $input['client_id']=$quotation['client_id'];
        $input['company_id']=$quotation['company_id'];
        $input['subtotal']=$subtotal;
        if($input['payment_type'] == "Initial 50%" || $input['payment_type'] == "Remainder 50%")
        {
            $quotation['total']=$total*0.5;
        }
        elseif($input['payment_type'] == "Twenty Percent - 20%")
        {
            $quotation['total']=$total*0.2;
        }
        elseif($input['payment_type'] == "Eighty Percent - 80%")
        {
            $quotation['total']=$total*0.8;
        }
        $input['total']=$total;
        $user = Auth::user();
        $uid = $user->id;
        $input['user_id'] = $uid;
        Invoice::create($input);
        Session::flash('flash_message', 'Invoice successfully added!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Invoice = Invoice::findOrFail($id);
        $qid=$Invoice->quotation_id;
        $quotation=Quotation::where('quotation_id', $qid)->get();
        $quotation=$quotation[0];
        $cid=$quotation->client_id;
        $client=Client::findOrFail($cid);
        $quotation['item']=unserialize($quotation['item']);
        $quotation['description']=unserialize($quotation['description']);
        $quotation['cost']=unserialize($quotation['cost']);
        $quotation['quantity']=unserialize($quotation['quantity']);
        $number=count($quotation['item']);
        $company=Company::findOrFail($quotation->company_id);
        $amount_due=$Invoice['subtotal']-$Invoice['total'];
        return view('invoices.show', compact('amount_due','number','client','company'))->withInvoice($Invoice)->withQuotation($quotation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $quotations = Quotation::all();
        $q = [];
        foreach ($quotations as $Quotation)
            {
                $q[$quotation->quotation_id] = $quotation->subject;
            }
        $quotations=$q;
        $companies = Company::all();
        $j = [];
        foreach ($companies as $company)
            {
                $j[$company->id] = $company->name;
            }
        $companies=$j;
        return view('invoices.edit',compact('quotations','companies'))->withInvoice($invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->validate($request, [
            'quotation_id' => 'required',
            'title' => 'required',
            'payment_type' => 'required',
            'invoice_status' => 'required',
            'created_at' => 'required',
            'company_id'=>'required'
        ]);
        $input = $request->all();
        $invoice->fill($input)->save();
        Session::flash('flash_message', 'Invoice successfully added!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        Session::flash('flash_message', 'Invoice successfully deleted!');
        return redirect()->route('invoices.index');
    }

    public function allinvoices($company)
    {
        $quotations = Quotation::where('company', $company)->get();
        $invoices=[];
        foreach($quotations as $quotation)
        {
            $invoices[]=Invoice::where('quotation_id', $quotation->quotation_id)->get();
        }
        if(empty($invoices))
        {}
        else
        {
            $invoices=$invoices[0];
        }
        $title =  $company.' Invoices';
        return view('invoices.index',compact('invoices','title'));
    }

    public function approve($id)
    {
        $uid=Auth::id();
        $invoice1 = Invoice::findOrFail($id);
        $invoice2="null";
        if($invoice1->payment_type == 'Initial 50%')
        {
            $qid=$invoice1->quotation_id;
            $client_id=$invoice1->client_id;
            $title = $invoice1->title;
            $payment_type='Remainder 50%';
            $invoice_status='Pending';
            $po = '';
            $total=$invoice1->total;
            $subtotal=$invoice1->subtotal;
            $created_at=Carbon::now();
            $company_id=$invoice1->company_id;
            $input= array('user_id'=>$uid,'total'=>$total,'subtotal'=>$subtotal,'quotation_id'=> $qid, 'client_id'=>$client_id, 'title' => $title, 'payment_type'=>$payment_type, 'invoice_status' => $invoice_status, 'purchase_order' => $po, 'created_at'=>$created_at, 'company_id'=>$company_id);
            $invoice2=Invoice::create($input);
        }
        else
        {
            $payment_term=Payment_term::where('payment_term',$invoice1->payment_type)->get();
            $qid=$invoice1->quotation_id;
            $client_id=$invoice1->client_id;
            $title = $invoice1->title;
            $payment_type=$invoice1->payment_type;
            $invoice_status='Pending';
            $po = '';
            $total=$invoice1->subtotal-$invoice1->total;
            $subtotal=$total;
            $created_at=Carbon::now();
            $company_id=$invoice1->company_id;
            $input= array('user_id'=>$uid,'total'=>$total,'subtotal'=>$subtotal,'quotation_id'=> $qid, 'client_id'=>$client_id, 'title' => $title, 'payment_type'=>$payment_type, 'invoice_status' => $invoice_status, 'purchase_order' => $po, 'created_at'=>$created_at, 'company_id'=>$company_id);
            $invoice2=Invoice::create($input);
        }
        $invoice1->invoice_status = 'Paid';
        $invoice1->save();
        Session::flash('flash_message', 'Invoice successfully added, quotation approved!');
        return view('invoices.approve',compact('invoice1','invoice2'));
    }
}