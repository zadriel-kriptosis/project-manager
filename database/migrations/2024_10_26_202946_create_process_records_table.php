<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('process_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('demand_id');
            $table->uuid('user_id')->nullable();
            $table->longText('description')->nullable();
            $table->integer('before_status_id');
            $table->integer('after_status_id');
            $table->string('file')->nullable();
            $table->string('img')->nullable();
            $table->timestamps();

            $table->foreign('demand_id')->references('id')->on('demands')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_records');
    }
};
