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
    public function __construct(){
            $this->middleware('jwt.auth');
    }


    public function index(Request $request)
    {      
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;
 
        if ($search_term)
        {
            $clients = Client::orderBy('id', 'DESC')->where('name', 'LIKE', "%$search_term%")->with(
            array('User'=>function($query){
                $query->select('id','name');
            })
            )->select('id', 'name', 'user_id')->paginate($limit); 
 
            $clients->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $clients = Client::orderBy('id', 'DESC')->with(
            array('User'=>function($query){
                $query->select('id','name');
            })
            )->select('id', 'name', 'user_id','company_name','registration_number','contact_number','address','country','email')->paginate($limit); 
 
            $clients->appends(array(            
                'limit' => $limit
            ));
        }
        
        return \Response::json($this->transformCollection($clients), 200);
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
        if(! $request->name or ! $request->user_id){
            return \Response::json([
                'error' => [
                    'message' => 'Please Provide Both name and user_id'
                ]
            ], 422);
        }
        $client = Client::create($request->all());
 
        return \Response::json([
                'message' => 'Client Created Succesfully',
                'data' => $this->transform($client)
        ]);
        /*$this->validate($request, [
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
        return redirect()->back();*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::with(
            array('User'=>function($query){
                $query->select('id','name');
            })
            )->find($id);
        if(!$client){
            return \Response::json([
                'error' => [
                    'message' => 'Client does not exist'
                ]
            ], 404);
        }
        return \Response::json($this->transform($client), 200);
        /*$client = Client::findOrFail($id);
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
        return view('clients.show',compact('amount_owed','amount_paid','quotations','invoices'))->withClient($client);*/
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
    public function update($id, Request $request)
    {

        if(! $request->name or ! $request->user_id){
            return \Response::json([
                'error' => [
                    'message' => 'Please Provide Both name and user_id'
                ]
            ], 422);
        }
        
        $client = Client::find($id);
        $client['name'] = $request->name;
        $client['user_id'] = $request->user_id;
        $client['company_name'] = $request->company_name;
        $client['registration_number'] = $request->registration_number;
        $client['address'] = $request->address;
        $client['country'] = $request->country;
        $client['email'] = $request->email;
        $client['contact_number'] = $request->contact_number;
        $client->save(); 
 
        return \Response::json([
                'message' => 'Client Updated Succesfully'
        ]);

        /*$client = Client::findOrFail($id);
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
        return redirect()->back();*/
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

    private function transformCollection($clients){
        $clientsArray = $clients->toArray();
        return [
            'total' => $clientsArray['total'],
            'per_page' => intval($clientsArray['per_page']),
            'current_page' => $clientsArray['current_page'],
            'last_page' => $clientsArray['last_page'],
            'next_page_url' => $clientsArray['next_page_url'],
            'prev_page_url' => $clientsArray['prev_page_url'],
            'from' => $clientsArray['from'],
            'to' =>$clientsArray['to'],
            'data' => array_map([$this, 'transform'], $clientsArray['data'])
        ];
    }
     
    private function transform($client){
        return [
               'client_id' => $client['id'],
               'user_id' => $client['user_id'],
               'name' => $client['name'],
               'company_name' => $client['company_name'],
               'registration_number' => $client['registration_number'],
               'address' => $client['address'],
               'country' => $client['country'],
               'email' => $client['email'],
               'contact_number' => $client['contact_number'],
               'submitted_by' => $client['user']['name']
            ];
    }
}