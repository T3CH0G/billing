<?php

namespace App\Mail;

use Carbon\Carbon;
use Auth;
use App\Quotation;
use App\Invoice;
use App\User;
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
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $id= $this->user->id;
        $user= $this->user;
        $quotations = Quotation::where('user_id',$id)->whereMonth('created_at',$now)->get();
        $invoices = Invoice::where('user_id',$id)->whereMonth('created_at',$now)->get();
        return $this->view('emails.welcome',compact('user','quotations','invoices'));
    }

}
