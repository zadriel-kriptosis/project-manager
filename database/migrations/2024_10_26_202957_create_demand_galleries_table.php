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
        Schema::create('demand_galleries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('demand_id');
            $table->string('img');
            $table->timestamps();

            $table->foreign('demand_id')->references('id')->on('demands')->onDelete('cascade');
        });
;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demand_galleries');
    }
};
