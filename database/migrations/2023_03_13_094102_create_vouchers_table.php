<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('quantity');
            $table->string('description');
            $table->integer('discount');
            $table->timestamp('start_day')->nullable();
            $table->timestamp('exp')->nullable();
            $table->integer('available');
            $table->integer('allow_multi');
            $table->softDeletes();
            $table->timestamps();
            $table->integer('admin_created');
            $table->integer('admin_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
};
