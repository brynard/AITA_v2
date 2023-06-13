<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserActivityHistoryTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activity_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('entity_type', ['project', 'item', 'loan']);
            $table->enum('action', ['create', 'edit', 'delete', 'approved', 'request', 'rejected', 'return']);
            $table->unsignedBigInteger('entity_id');
            $table->text('description');
            $table->json('changes')->nullable();
            $table->timestamp('action_timestamp')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_activity_history');
    }
}
