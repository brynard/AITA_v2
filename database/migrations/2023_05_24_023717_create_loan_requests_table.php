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
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_details_id');
            $table->unsignedBigInteger('requester_id');
            $table->unsignedBigInteger('owner_id');
            $table->string('desc');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('return_status', ['not_returned', 'returned'])->default('not_returned');
            $table->dateTime('loan_start_date')->nullable();
            $table->dateTime('loan_end_date')->nullable();
            $table->timestamps();



             // Add foreign key constraints
             $table->foreign('project_details_id')->references('id')->on('project_details')->onDelete('cascade');
             $table->foreign('requester_id')->references('id')->on('users')->onDelete('cascade');
             $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};
