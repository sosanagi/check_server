<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerSoftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_softs', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('server_id')->default('');
            $table->string('os_name')->default('');
            $table->string('release')->default('');
            $table->string('hardwaretype')->default('');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_softs');
    }
}
