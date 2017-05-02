<?php

namespace App\Http\Controllers;

use App\Company;
use App\Invoice;
use Auth;
use App\Payment_term;
use App\Quotation;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class PaymentTermsController extends Controller
{
    public function index($id)
    {
        $payment_terms = Payment_term::where('company_id',$id);
        return view('payment_terms.index',compact('payment_terms'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
    	$company=Company::findorFail($id);
        return view('payment_terms.create',compact('company'));
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
        'payment_term' => 'required',
        'invoice_1' => 'required',
        'company_id'=> 'required',
        ]);
        $input = $request->all();
        Payment_term::create($input);
        Session::flash('flash_message', 'payment_term successfully added!');
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
        $payment_term = Payment_term::findOrFail($id);
        return view('payment_terms.show')->withPayment_term($payment_term);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment_term = Payment_term::findOrFail($id);
        return view('payment_terms.edit')->withPayment_term($payment_term);
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
        $payment_term = Payment_term::findOrFail($id);
         $this->validate($request, [
	        'payment_term' => 'required',
	        'invoice_1' => 'required'
        ]);
        $input = $request->all();
        $payment_term->fill($input)->save();
        Session::flash('flash_message', 'payment_term successfully added!');
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
        $payment_term = Payment_term::findOrFail($id);
        $payment_term->delete();
        Session::flash('flash_message', 'payment_term successfully deleted!');
        return redirect()->route('payment_terms.index');
    }
}