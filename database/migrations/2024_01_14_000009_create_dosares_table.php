<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosaresTable extends Migration
{
    public function up()
    {
        Schema::create('dosares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')->nullable();
            $table->string('name');
            $table->string('first_name');
            $table->string('company_name')->nullable();
            $table->integer('cui');
            $table->datetime('incident_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
