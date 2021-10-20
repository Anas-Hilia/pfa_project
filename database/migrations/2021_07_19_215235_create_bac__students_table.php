<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBacStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        if(!Schema::hasTable('bac_student')){
            Schema::create('bac_student', function (Blueprint $table) {
                
                $table->engine = 'InnoDB';
                
                $table->bigIncrements('id_BacS')->unsigned();
                $table->unsignedBigInteger('id_student')->unsigned()->index();
                $table->string('serie')->nullable();
                $table->string('academy')->nullable();
                $table->string('establishment_1')->nullable();
                $table->integer('bac_year')->nullable();
                
                $table->foreign('id_student')->references('id_S')->on('students')->onDelete('cascade');
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
        Schema::dropIfExists('bac_student');
    }
}
