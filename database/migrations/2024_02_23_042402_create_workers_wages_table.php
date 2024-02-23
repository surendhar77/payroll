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
        Schema::create('workers_wages', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id');
            $table->enum('salary_type', ['weekly', 'monthly']);
            $table->integer('weekly_salary')->null();
            $table->integer('monthly_salary')->null();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers_wages');
    }
};
