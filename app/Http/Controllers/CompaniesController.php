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
    public function __construct(){
            $this->middleware('jwt.auth');
    }


    public function index(Request $request)
    {      
        $search_term = $request->input('search');
        $limit = $request->input('limit')?$request->input('limit'):5;
 
        if ($search_term)
        {
            $companies = Company::orderBy('id', 'DESC')->where('name', 'LIKE', "%$search_term%")->with(
            array('User'=>function($query){
                $query->select('id','name');
            })
            )->select('id', 'name', 'user_id')->paginate($limit); 
 
            $companies->appends(array(
                'search' => $search_term,
                'limit' => $limit
            ));
        }
        else
        {
            $companies = Company::orderBy('id', 'DESC')->with(
            array('User'=>function($query){
                $query->select('id','name');
            })
            )->select('id', 'name', 'user_id')->paginate($limit); 
 
            $companies->appends(array(            
                'limit' => $limit
            ));
        }
        
        return \Response::json($this->transformCollection($companies), 200);
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
        if(! $request->name or ! $request->user_id){
            return \Response::json([
                'error' => [
                    'message' => 'Please Provide Both name and user_id'
                ]
            ], 422);
        }
        $company = Company::create($request->all());
 
        return \Response::json([
                'message' => 'Company Created Succesfully',
                'data' => $this->transform($company)
        ]);
        /*$this->validate($request, [
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
        $company = Company::with(
            array('User'=>function($query){
                $query->select('id','name');
            })
            )->find($id);
        if(!$company){
            return \Response::json([
                'error' => [
                    'message' => 'Company does not exist'
                ]
            ], 404);
        }
        $previous = Company::where('id', '<', $company->id)->max('id');
        $next = Company::where('id', '>', $company->id)->min('id');
        return \Response::json([
            'previous_company_id'=> $previous,
            'next_company_id'=> $next,
            'data' => $this->transform($company)
        ], 200);
        /*$company = Company::findOrFail($id);
        $uid=$company->user_id;
        $user = User::findOrFail($uid);
        $quotations = Quotation::where('company_id', $company->id)->get();
        $invoices = Invoice::where('company_id', $company->id)->get();
        $payment_terms = Payment_term::where('company_id', $company->id)->get();
        return view('companies.show',compact('payment_terms','number','user','quotations','invoices','file'))->withCompany($company);*/
    }

    /**
     * Show the form for editing the specified resource.

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
        
        $company = Company::find($id);
        $company['name'] = $request->name;
        $company['user_id'] = $request->user_id;
        $company->save(); 
 
        return \Response::json([
                'message' => 'Company Updated Succesfully'
        ]);
        /*$company = Company::findOrFail($id);
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
        Company::destroy($id);
        /*$company = Company::findOrFail($id);
        $path = public_path().'/images/'.$id.'.png';
        File::delete($path);
        $company->delete();
        Session::flash('flash_message', 'Company successfully deleted!');
        return redirect()->route('companies.index');*/
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

    private function transformCollection($companies){
        $companiesArray = $companies->toArray();
        return [
            'total' => $companiesArray['total'],
            'per_page' => intval($companiesArray['per_page']),
            'current_page' => $companiesArray['current_page'],
            'last_page' => $companiesArray['last_page'],
            'next_page_url' => $companiesArray['next_page_url'],
            'prev_page_url' => $companiesArray['prev_page_url'],
            'from' => $companiesArray['from'],
            'to' =>$companiesArray['to'],
            'data' => array_map([$this, 'transform'], $companiesArray['data'])
        ];
    }
     
    private function transform($company){
        return [
               'company_id' => $company['id'],
               'company' => $company['name'],
               'submitted_by' => $company['user']['name']
            ];
    }
}
