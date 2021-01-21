<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServerDisks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_disks', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('server_id')->default('');
            $table->string('mount')->default('');
            $table->string('device')->default('');
            $table->string('free')->default('');
            $table->string('fstype')->default('');
            $table->string('percent')->default('');
            $table->string('total')->default('');
            $table->string('used')->default('');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_disks');
    }
}
