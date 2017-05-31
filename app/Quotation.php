<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
       protected $fillable = [
        'client_id',
        'company_id',
        'quotation_id',
        'item',
        'subject',
        'description',
        'cost',
        'quantity',
        'payment_type',
        'quotation_status',
        'discount',
        'created_at',
        'amount_paid',
        'total',
        'subtotal',
        'user_id',
        'currency'
    ];

    public function client()
    {
        return $this->hasOne('App\Client');
    }
    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    }
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
