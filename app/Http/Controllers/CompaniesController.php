<?php

namespace App\Http\Controllers;
use Auth;
use File;
use Carbon\Carbon;
use App\Payment_term;
use App\Company;
use App\User;
use App\Client;
use App\Quotation;
use App\Invoice;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class CompaniesController extends Controller
{
    public function index()
    {
        $user=Auth::user();
        $companies = Company::where('user_id',$user->id)->get();
        return view('companies.index',compact('companies'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
        'image' => 'required',
        'imageName' => 'required'
        ]);
        $input = $request->all();
        $user = Auth::user();
        $uid = $user->id;
        $input['user_id'] = $uid;
        $company=Company::create($input);
        $imageName = $company->id . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(base_path() . '/public/images/', $imageName);
        $company->imageName = $imageName;
        $company->save();
        Session::flash('flash_message', 'Company successfully added!');
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
        $company = Company::findOrFail($id);
        $uid=$company->user_id;
        $user = User::findOrFail($uid);
        $quotations = Quotation::where('company_id', $company->id)->get();
        $invoices = Invoice::where('company_id', $company->id)->get();
        $payment_terms = Payment_term::where('company_id', $company->id)->get();
        return view('companies.show',compact('payment_terms','number','user','quotations','invoices','file'))->withCompany($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companies = Company::findOrFail($id);
        return view('companies.edit')->withCompany($companies);
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
        $company = Company::findOrFail($id);
        $path = public_path().'/images/'.$id.'.png';
        File::delete($path);
        $this->validate($request, [
            'name' => 'required',
            'image'=> 'required'
        ]);
        $input = $request->all();
        $imageName = $company->id . '.' . 
            $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(
            base_path() . '/public/images/', $imageName
        );
        $company->fill($input)->save();
        Session::flash('flash_message', 'Company successfully added!');
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
        $company = Company::findOrFail($id);
        $path = public_path().'/images/'.$id.'.png';
        File::delete($path);
        $company->delete();
        Session::flash('flash_message', 'Company successfully deleted!');
        return redirect()->route('companies.index');
    }

    public function sales($id)
    {
        $company = Company::findOrFail($id); 
        $now = Carbon::now(); 
        $now = $now->month;
        $quotations = DB::table('quotations')->whereMonth('created_at',$now)->where('company_id','=',$company->id)->get();
        $invoices = DB::table('invoices')->whereMonth('created_at',$now)->where('company_id','=',$company->id)->get();
        $user = Auth::user();
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
        return view('companies.sales',compact('quotations','invoices','user','real_sales','potential_sales'))->withCompany($company);
    }
}
