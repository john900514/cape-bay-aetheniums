<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('name');
            $table->string('icon')->default('las la-palette');
            $table->string('listing_route');
            $table->uuid('project_id');

            $table->string('permitted_role')->nullable();
            $table->string('permitted_abilities')->nullable();

            $table->longText('desc')->nullable();
            $table->longText('misc')->nullable();

            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
