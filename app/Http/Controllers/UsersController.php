<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Invoice;
use Auth;
use App\Company;
use App\User;
use App\Client;
use App\Quotation;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */

    public function profile()
    {
        if(Auth::guest())
        {
            return view('welcome');
        }
        else
        {
            $user=Auth::user();
            $companies = Company::where('user_id',$user->id)->get();
            $clients = Client::where('user_id',$user->id)->get();
            return view('welcome',compact('companies','user','clients'));
        }
    }

    public function breakdown()
    {
        $now = Carbon::now(); 
        $now = $now->month;
        $user=Auth::user();
        $quotations = Quotation::where('user_id',$user->id)->whereMonth('created_at',$now)->get();
        $invoices = Invoice::where('user_id',$user->id)->whereMonth('created_at',$now)->get();
        $real_sales=0;
        $potential_sales=0;
        foreach($quotations as $quotation)
        {
            $potential_sales=$potential_sales+$quotation->total-$quotation->amount_paid;
        }
        foreach($invoices as $invoice)
        {
            $real_sales=$real_sales+$invoice->total;
        }
        return view('users.breakdown',compact('potential_sales','real_sales','user','quotations','invoices'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        $user->fill($input)->save();
        Session::flash('flash_message', 'Client successfully added!');
        return redirect()->back();
    }
}