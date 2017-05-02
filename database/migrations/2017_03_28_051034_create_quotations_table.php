<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations',function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('user_id');
            $table->string('company_id');
            $table->integer('client_id');
            $table->string('quotation_id');
            $table->string('subject');
            $table->string('item');
            $table->text('description');
            $table->string('cost');
            $table->string('quantity');
            $table->string('payment_type');
            $table->string('quotation_status');
            $table->integer('discount')->default(0);
            $table->string('amount_paid')->default(0);
            $table->string('currency');
            $table->string('subtotal');
            $table->string('total');
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
        Schema::drop('quotations');
    }
}
