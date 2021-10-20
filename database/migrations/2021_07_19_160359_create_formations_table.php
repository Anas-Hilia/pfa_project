<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('formations')){
            Schema::create('formations', function (Blueprint $table) {
                
                $table->engine = 'InnoDB';

                $table->bigIncrements('id')->unsigned();
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->string('description')->nullable();
                $table->integer('nbr_max')->nullable();
                $table->boolean('c_accepted')->default(0);
                $table->boolean('u_accepted')->default(1);
                $table->unsignedBigInteger('created_by')->unsigned()->index()->default(1);
                $table->unsignedBigInteger('updated_by')->unsigned()->index()->nullable();
                $table->unsignedBigInteger('deleted_by')->unsigned()->index()->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');

                

                
                $table->timestamps();
                $table->softDeletes();

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
        Schema::dropIfExists('formations');
        
    }
}
