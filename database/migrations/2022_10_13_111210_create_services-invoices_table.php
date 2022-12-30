<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services-invoices', function (Blueprint $table) {
            $table->id();
            $table->string('hashID')->unique();
            $table->string('seira')->default('ΑΝΕΥ');
            $table->unsignedBigInteger('invoiceID');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->date('date');
            $table->boolean('paid');
            $table->unsignedBigInteger('payment_method')->nullable()->default(5);
            $table->string('mark')->unique()->nullable();
            $table->string('file_invoice')->nullable();
            $table->integer('has_parakratisi')->default(NULL);
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