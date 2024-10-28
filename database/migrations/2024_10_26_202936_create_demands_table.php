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
        Schema::create('demands', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('creator_id')->nullable();
            $table->longText('title');
            $table->longText('description')->nullable();
            $table->uuid('project_id');
            $table->integer('status_id')->default(0)->comment('0-> Waiting Start , 1-> Working, 2-> Controlling, 3-> Completed, 4-> Cancelled');
            $table->integer('type_id')->default(0)->comment('0-> Bug, 1-> Development, 2-> Test, 3-> Other');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demands');
    }
};
