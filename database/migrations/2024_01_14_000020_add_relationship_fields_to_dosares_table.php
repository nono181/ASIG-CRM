<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDosaresTable extends Migration
{
    public function up()
    {
        Schema::table('dosares', function (Blueprint $table) {
            $table->unsignedBigInteger('email_id')->nullable();
            $table->foreign('email_id', 'email_fk_9246339')->references('id')->on('users');
        });
    }
}
