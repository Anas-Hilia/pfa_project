<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiplomaStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        if(!Schema::hasTable('diploma_student')){
            Schema::create('diploma_student', function (Blueprint $table) {
                
                $table->engine = 'InnoDB';
                
                $table->bigIncrements('id_DiplS')->unsigned();
                $table->unsignedBigInteger('id_student')->unsigned()->index();
                $table->string('diploma')->nullable();
                $table->date('date_obtained')->nullable();
                $table->string('establishment_2')->nullable();
                
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
        Schema::dropIfExists('diploma_student');
    }
}
