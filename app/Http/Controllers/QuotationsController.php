<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Payment_term;
use App\Company;
use App\Quotation;
use App\Invoice;
use App\Client;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class QuotationsController extends Controller
{
public function __construct(){
            $this->middleware('jwt.auth');
    }


    public function index(Request $request)
    {      
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;
 
        if ($search_term)
        {
            $quotations = Quotation::orderBy('id', 'DESC')->where('name', 'LIKE', "%$search_term%")->with(
            array('User'=>function($query){
                $query->select('id','name');
            })
            )->select('id', 'name', 'user_id')->paginate($limit); 
 
            $quotations->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $quotations = Quotation::orderBy('id', 'DESC')->with(
            array('User'=>function($query){
                $query->select('id','name');
            })
            )->select('client_id','subject','item','description','cost','quantity','quotation_status','created_at','amount_paid','company_id','payment_type','currency','quotation_id')->paginate($limit); 
 
            $quotations->appends(array(            
                'limit' => $limit
            ));
        }
        return \Response::json($this->transformCollection($quotations), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $quotations = Client::all();
        $q = [];
        foreach ($quotations as $client)
            {
                $q[$client->id] = $client->name;
            }
        $quotations=$q;
        $j=[];
        $j['Upfront 50%']='Upfront 50%';
        $j['60 days within live date']='60 days within live date';
        $j['Monthly'] = 'Monthly';
        $j['Order'] = 'Order';
        $payment_terms=Payment_term::where('company_id',$id)->get();
        foreach ($payment_terms as $terms)
            {
                $j[$terms->payment_term] = $terms->payment_term;
            }
        $payments=$j;
        $company=Company::findOrFail($id);
        return view('quotations.create',compact('quotations','company','payments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! $request->subject or ! $request->user_id){
            return \Response::json([
                'error' => [
                    'message' => 'Please Provide Both subject and user_id'
            ], 422]);
        }
        $client_id = $request->client_id;
        $client=Client::findOrFail($client_id);
        $job_id = DB::table('clients')->where('id', $client_id)->value('job_number');
        $job_id = $job_id + 1;
        $update = DB::table('clients')->where('id', $client_id);
        $update->update(['job_number' => $job_id]);
        if ($job_id <= 9)
            {
                $job_id='0'.$job_id;
            }
        $cid ="0"."$client_id";
        $input = $request->all();
        if($client_id < 10)
            {
                $input['quotation_id'] = $cid.$job_id;
            }
        elseif ($client_id >= 10) 
            {
                $input['quotation_id'] = $client_id.$job_id;
            }
        /*$number=count($input['item']);
        $total = 0;
        $discount = $input['discount'];
        for($i = 0; $i < $number; $i++)
            {
                $total = $total + $input['cost'][$i]*$input['quantity'][$i];
            }
        $subtotal=$total;
        $input['subtotal']=$subtotal;
        $total=$total*((100-$discount)/100);
        $input['total']=$total;*/
        $input['item']=serialize($input['item']);
        $input['description']=serialize($input['description']);
        $input['cost']=serialize($input['cost']);
        $input['quantity']=serialize($input['quantity']);
        Quotation::create($input);
        return \Response::json([
                'message' => 'Quotation Created Succesfully',
                'data' => $this->transform($quotation)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);
        $cid=$quotation->client_id;
        $client=Client::findOrFail($cid);
        $quotation['item']=unserialize($quotation['item']);
        $quotation['description']=unserialize($quotation['description']);
        $quotation['cost']=unserialize($quotation['cost']);
        $quotation['quantity']=unserialize($quotation['quantity']);
        $amount_paid = $quotation['amount_paid'];
        $amount_owed = $quotation['total']- $amount_paid;
        $company=Company::findOrFail($quotation->company_id);
        $number=count($quotation['item']);
        return view('quotations.show', compact('number','amount_paid','amount_owed','company'))->withQuotation($quotation)->withClient($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotations = Client::all();
        $q = [];
        foreach ($quotations as $client)
            {
                $q[$client->id] = $client->name;
            }
        $quotations=$q;
        $companies = Company::all();
        $j = [];
        foreach ($companies as $company)
            {
                $j[$company->id] = $company->name;
            }
        $companies=$j;
        $quotation['item']=unserialize($quotation['item']);
        $quotation['description']=unserialize($quotation['description']);
        $quotation['cost']=unserialize($quotation['cost']);
        $quotation['quantity']=unserialize($quotation['quantity']);
        $number=count($quotation['item']);
        return view('quotations.edit',compact('quotations','number','companies'))->withQuotation($quotation);
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
        $quotation = Quotation::findOrFail($id);
            $this->validate($request, [
            'client_id' => 'required',
            'quotation_id' => 'required',
            'subject' => 'required',
            'item' => 'required',
            'description' => 'required',
            'cost' => 'required',
            'quantity' => 'required',
            'payment_type' => 'required',
            'quotation_status' => 'required',
            'created_at' => 'required',
            'amount_paid' => 'required',
            'company_id'=>'required'
            ]);
        $input = $request->all();
        $input['item']=serialize($input['item']);
        $input['description']=serialize($input['description']);
        $input['cost']=serialize($input['cost']);
        $input['quantity']=serialize($input['quantity']);
        $quotation->fill($input)->save();
        Session::flash('flash_message', 'Quotation successfully added!');
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
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();
        Session::flash('flash_message', 'Quotation successfully deleted!');
        return redirect()->route('quotations.index');
    }

    public function approve($id)
    {
        $uid = Auth::id();
        $quotation = Quotation::findOrFail($id);
        $invoice='null';
        if($quotation->payment_type=="Upfront 50%")
            {
                $qid=$quotation->quotation_id;
                $client_id=$quotation->client_id;
                $title = $quotation->subject;
                $payment_type='Initial 50%';
                $invoice_status='Pending';
                $po = '';
                $created_at=Carbon::now();
                $company_id=$quotation->company_id;
                $items=unserialize($quotation['item']);
                $costs=unserialize($quotation['cost']);
                $quantities=unserialize($quotation['quantity']);
                $number=count($items);
                $total = 0;
                $discount = $quotation['discount'];
                for($i = 0; $i < $number; $i++)
                {
                    $total = $total + $costs[$i]*$quantities[$i];
                }
                $subtotal=$total;
                $total=$total*((100-$discount)/100);
                $input['subtotal']=$subtotal;
                $total=$total*0.5;
                $input= array('user_id'=>$uid,'total'=>$total,'subtotal'=>$subtotal,'quotation_id'=> $qid, 'client_id'=>$client_id, 'title' => $title, 'payment_type'=>$payment_type, 'invoice_status' => $invoice_status, 'purchase_order' => $po, 'created_at'=>$created_at, 'company_id'=>$company_id);
                $invoice=Invoice::create($input);
            }
        else
            {
                $payment_term=Payment_term::where('payment_term',$quotation->payment_type)->get();
                $payment_term=$payment_term[0];
                $qid=$quotation->quotation_id;
                $client_id=$quotation->client_id;
                $title = $quotation->subject;
                $payment_type = $quotation->payment_type;
                $invoice_status='Pending';
                $po = '';
                $created_at=Carbon::now();
                $company_id=$quotation->company_id;
                $items=unserialize($quotation['item']);
                $costs=unserialize($quotation['cost']);
                $quantities=unserialize($quotation['quantity']);
                $number=count($items);
                $total = 0;
                $discount = $quotation['discount'];
                for($i = 0; $i < $number; $i++)
                {
                    $total = $total + $costs[$i]*$quantities[$i];
                }
                $subtotal=$total;
                $total=$total*((100-$discount)/100);
                $input['subtotal']=$subtotal;
                $total=$total*(($payment_term->invoice_1)/100);
                $input= array('user_id'=>$uid,'total'=>$total,'subtotal'=>$subtotal,'quotation_id'=> $qid, 'client_id'=>$client_id, 'title' => $title, 'payment_type'=>$payment_type, 'invoice_status' => $invoice_status, 'purchase_order' => $po, 'created_at'=>$created_at, 'company_id'=>$company_id);
                $invoice=Invoice::create($input);
            }
        $quotation->quotation_status = 'Approved';
        $quotation->save();
        Session::flash('flash_message', 'Invoice successfully added, quotation approved!');
        return view('quotations.approve',compact('invoice','quotation'));
    }


    private function transformCollection($quotations){
        $quotationsArray = $quotations->toArray();
        return [
            'total' => $quotationsArray['total'],
            'per_page' => intval($quotationsArray['per_page']),
            'current_page' => $quotationsArray['current_page'],
            'last_page' => $quotationsArray['last_page'],
            'next_page_url' => $quotationsArray['next_page_url'],
            'prev_page_url' => $quotationsArray['prev_page_url'],
            'from' => $quotationsArray['from'],
            'to' =>$quotationsArray['to'],
            'data' => array_map([$this, 'transform'], $quotationsArray['data'])
        ];
    }
     
    private function transform($quotation){
        return [

               'client_id' => $quotation['client_id'],
               'subject' => $quotation['subject'],
               'item' => $quotation['item'],
               'description' => $quotation['description'],
               'cost' => $quotation['cost'],
               'quantity' => $quotation['quantity'],
               'quotation_status' => $quotation['quotation_status'],
               'created_at' => $quotation['created_at'],
               'amount_paid' => $quotation['amount_paid'],
               'company_id' => $quotation['company_id'],
               'payment_type' => $quotation['payment_type'],
               'currency' => $quotation['currency'],
            ];
    }
}