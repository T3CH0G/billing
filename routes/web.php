<?php
use Illuminate\Support\Facades\Auth;
use App\Mail\Breakdown;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*profile and registration routes*/
Auth::routes();
Route::get('/home','HomeController@index');
Route::get('/', 'UsersController@profile');
Route::get('register/verify/{token}', 'Auth\RegisterController@verify');
/*CRUD routes*/
Route::resource('/quotations', 'QuotationsController');
Route::resource('/invoices', 'InvoicesController');
Route::resource('/clients', 'ClientsController');
Route::resource('/users', 'UsersController');
Route::resource('/payment_terms', 'PaymentTermsController');
Route::get('/quotations/create/{id}','QuotationsController@create');
Route::get('/payment_terms/create/{id}','PaymentTermsController@create');
/*Other routes*/
Route::get('/approvequotation/{id}', 'QuotationsController@approve');
Route::get('/approveinvoice/{id}', 'InvoicesController@approve');
Route::get('/companies/sales/{id}', 'CompaniesController@sales');  
Route::get('/breakdown', 'UsersController@breakdown');
/*Email route*/
Route::get('/mail', function () {
	$user=Auth::user();
    Mail::to($user->email)->send(new Breakdown);
    return view('emails.sent');
});

Route::group(['middleware' => 'cors', 'prefix' => 'api'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');
});
 
Route::group(['middleware' => 'cors', 'prefix' => 'api'], function(){
	Route::resource('companies', 'CompaniesController');
});


