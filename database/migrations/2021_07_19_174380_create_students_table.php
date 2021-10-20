<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('students')){
            Schema::create('students', function (Blueprint $table) {
                
                $table->engine = 'InnoDB';
                
                $table->bigIncrements('id_S')->unsigned();
                $table->unsignedBigInteger('id_user')->unsigned()->index();
                $table->unsignedBigInteger('id_branche_formation')->unsigned()->index();
                $table->string('CNE')->nullable();
                $table->string('CIN')->nullable();
                $table->boolean('validate')->nullable();

                $table->date('date_birth')->nullable();
                $table->string('place_birth')->nullable();
                // $table->string('tranche_1')->nullable();
                // $table->string('tranche_2')->nullable();
                // $table->double('amount_tr1', 5, 2)->default(0);
                // $table->double('amount_tr2', 5, 2)->default(0);
                // $table->boolean('status_tr1')->default(0);
                // $table->boolean('status_tr2')->default(0);

                $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('id_branche_formation')->references('id_BrF')->on('branches_formations')->onDelete('cascade');

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
        Schema::dropIfExists('students');
    }
}
