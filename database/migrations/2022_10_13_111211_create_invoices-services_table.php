<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice-services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_number')->nullable();
            $table->string('seira')->default('');
            $table->foreign('invoice_number')->references('invoiceID')->on('services-invoices')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->bigInteger('price');
            $table->integer('quantity');
            $table->text('description');
            $table->softDeletes();
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
        //
    }
}
