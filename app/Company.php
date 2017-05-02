<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
        protected $fillable = [
        'user_id',
        'name',
        'imageName',
        'address1',
        'address2',
        'address3',
        'address4',
        'address5',
        'registration_number',
        'custom_payment_term',
        'invoice_1',
        'invoice_2',
        'bank_account_MY',
        'bank_account_SG',
        'GST'
    ];
}