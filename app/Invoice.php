<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
        protected $fillable = [
        'client_id',
        'quotation_id',
        'title',
        'payment_type',
        'invoice_status',
        'purchase_order',
        'created_at',
        'company_id',
        'total',
        'subtotal',
        'user_id'
    ];

        public function quotation()
    {
        return $this->hasOne('App\Quotation');
    }
}
