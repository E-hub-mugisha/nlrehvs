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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employment_history_id')->constrained('employment_histories')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // who raises the dispute
            $table->text('reason'); // employee's dispute reason
            $table->enum('status', ['pending', 'resolved', 'rejected'])->default('pending');
            $table->text('admin_comment')->nullable(); // admin response
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
