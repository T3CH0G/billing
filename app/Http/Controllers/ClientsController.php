<?php

namespace App\Http\Controllers;

use App\Invoice;
use Auth;
use App\Client;
use App\Quotation;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index',compact('clients'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
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
        'name' => 'required',
        'company_name' => 'required',
        'registration_number' => 'required',
        'address' => 'required',
        'user_id' => 'required'
        ]);
        $input = $request->all();
        $user = Auth::user();
        $uid = $user->id;
        $input['user_id'] = $uid;
        Client::create($input);
        Session::flash('flash_message', 'Client successfully added!');
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
        $client = Client::findOrFail($id);
        $quotations = Quotation::where('client_id', $client->id)->get();
        $invoices=Invoice::where('client_id',$client->id)->get();
        $amount_paid=0;
        $amount_owed=0;
        foreach($quotations as $quotation)
        {
            if($quotation->quotation_status=='Pending'){
            $amount_owed=$amount_owed+$quotation['total']-$quotation['amount_paid'];
            $amount_paid=$amount_paid+$quotation['amount_paid'];}
        }
        foreach($invoices as $invoice)
        {
            if($invoice->invoice_status=='Pending')
            {
                $amount_owed=$amount_owed+$invoice['total'];
            }
            elseif($invoice->invoice_status=='Paid')
            {
                $amount_paid=$amount_paid+$invoice['total'];
            }
        }
        return view('clients.show',compact('amount_owed','amount_paid','quotations','invoices'))->withClient($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit')->withClient($client);
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
        $client = Client::findOrFail($id);
         $this->validate($request, [
            'name' => 'required',
            'company_name' => 'required',
            'registration_number' => 'required',
            'address' => 'required',
            'user_id' => 'required'
        ]);
        $input = $request->all();
        $client->fill($input)->save();
        Session::flash('flash_message', 'Client successfully added!');
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
        $client = Client::findOrFail($id);
        $client->delete();
        Session::flash('flash_message', 'Client successfully deleted!');
        return redirect()->route('clients.index');
    }
}
