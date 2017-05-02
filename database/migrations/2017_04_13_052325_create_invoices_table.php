<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('client_id');
            $table->string('company_id');
            $table->string('quotation_id');
            $table->string('title');
            $table->string('payment_type');
            $table->string('invoice_status');
            $table->string('total');
            $table->string('subtotal');
            $table->string('purchase_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
