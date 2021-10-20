<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesFormationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('branches_formations')){

            
            Schema::create('branches_formations', function (Blueprint $table) {

                $table->engine = 'InnoDB';
                $table->bigIncrements('id_BrF');
                $table->string('name');
                $table->unsignedBigInteger('coordinateur')->unsigned()->index();
                $table->unsignedBigInteger('id_formation')->unsigned()->index();
                $table->string('description');
                $table->boolean('c_accepted')->default(0);
                $table->boolean('u_accepted')->default(1);
                

                //Relationships
                $table->foreign('coordinateur')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('id_formation')->references('id')->on('formations')->onDelete('cascade');
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
        Schema::dropIfExists('branches_formation');
    }
}


