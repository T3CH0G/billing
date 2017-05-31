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
            $table->integer('client_id')->nullable();
            $table->string('quotation_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('item')->nullable();
            $table->text('description')->nullable();
            $table->string('cost')->nullable();
            $table->string('quantity')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('quotation_status')->nullable();
            $table->integer('discount')->default(0);
            $table->string('amount_paid')->default(0);
            $table->string('currency')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('total')->nullable();
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
