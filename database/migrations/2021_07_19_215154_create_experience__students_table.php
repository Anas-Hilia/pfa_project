<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienceStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        if(!Schema::hasTable('experience_student')){
            Schema::create('experience_student', function (Blueprint $table) {
                
                $table->engine = 'InnoDB';
                
                $table->bigIncrements('id_ExpS')->unsigned();
                $table->unsignedBigInteger('id_student')->unsigned()->index();
                $table->string('employer_organization')->nullable();
                $table->string('poste_occupied')->nullable();
                
                
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
        Schema::dropIfExists('experience_student');
    }
}
