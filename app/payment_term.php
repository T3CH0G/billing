<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment_term extends Model
{
    protected $fillable = ['payment_term', 'invoice_1', 'invoice_2','company_id'];
}
