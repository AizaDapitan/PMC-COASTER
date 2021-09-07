<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('empId');
            $table->string('name');
            $table->string('dept')->default('Outsider');
            $table->string('location')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('expireDate');
            $table->integer('cid')->nullable();
            $table->boolean('isNotActive')->default(false);
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
        Schema::dropIfExists('employees');
    }
}
