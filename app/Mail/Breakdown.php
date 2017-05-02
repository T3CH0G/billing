<?php

namespace App\Mail;

use Carbon\Carbon;
use Auth;
use App\Quotation;
use App\Invoice;
use Illuminate\Http\Request;
use Session;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Breakdown extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $now = Carbon::now(); 
        $now = $now->month;
        $user=Auth::user();
        $quotations = Quotation::where('user_id',$user->id)->whereMonth('created_at',$now)->get();
        $invoices = Invoice::where('user_id',$user->id)->whereMonth('created_at',$now)->get();
        return $this->view('emails.welcome',compact('user','quotations','invoices'));
    }

}
