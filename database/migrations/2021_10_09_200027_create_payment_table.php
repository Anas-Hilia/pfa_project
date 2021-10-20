<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('payment')){
            Schema::create('payment', function (Blueprint $table) {
                
                $table->engine = 'InnoDB';

                $table->id('id_payment');
                $table->unsignedBigInteger('id_S')->unsigned()->index();
                $table->double('s1_amount', 5, 2)->default(0);
                $table->string('s1_receipt')->nullable();
                $table->date('s1_date')->nullable();
                $table->boolean('status_s1')->default(0);
                $table->double('s2_amount', 5, 2)->default(0);
                $table->string('s2_receipt')->nullable();
                $table->date('s2_date')->nullable();
                $table->boolean('status_s2')->default(0);
                $table->double('s3_amount', 5, 2)->default(0);
                $table->string('s3_receipt')->nullable();
                $table->date('s3_date')->nullable();
                $table->boolean('status_s3')->default(0);
                $table->double('s4_amount', 5, 2)->default(0);
                $table->string('s4_receipt')->nullable();
                $table->date('s4_date')->nullable();
                $table->boolean('status_s4')->default(0);
                $table->foreign('id_S')->references('id_S')->on('students')->onDelete('cascade');
                $table->timestamps();
                

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
}
