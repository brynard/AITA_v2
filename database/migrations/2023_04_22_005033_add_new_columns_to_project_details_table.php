<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToProjectDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('project_details', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('item_name');
            $table->decimal('unit_price', 10, 2)->default(0.00)->after('quantity');
            $table->string('subtype')->nullable()->after('unit_price');
            $table->string('serial_number')->nullable()->after('subtype');
            $table->string('model')->nullable()->after('serial_number');
            $table->string('engine_type')->nullable()->after('model');
            $table->integer('voltage')->nullable()->after('engine_type');
            $table->string('supplier')->nullable()->after('voltage');
            $table->string('location')->nullable()->after('supplier');
        });
    }

    public function down()
    {
        Schema::table('project_details', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('unit_price');
            $table->dropColumn('subtype');
            $table->dropColumn('serial_number');
            $table->dropColumn('model');
            $table->dropColumn('engine_type');
            $table->dropColumn('voltage');
            $table->dropColumn('supplier');
            $table->dropColumn('location');
        });
    }
}
