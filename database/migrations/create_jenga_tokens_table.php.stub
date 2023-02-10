<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::create(table: 'jenga_tokens', callback: function (Blueprint $table) {
           $table->id();

           $table->text(column: 'access_token')->index();
           $table->text(column: 'refresh_token')->unique();
           $table->timestamp(column: 'expires_in');
           $table->string(column: 'token_type')->default('Bearer');
           $table->timestamp(column: 'issued_at');

           $table->timestamps();
       });
    }
};
