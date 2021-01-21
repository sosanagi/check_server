<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServerIdSets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_sets', function (Blueprint $table) {
            $table->string('id');
            $table->string('cpu_id');
            $table->string('memory_id');
            $table->string('net_id');
            $table->string('disk_id');
            $table->string('os_id');

            $table->foreign('id')
                ->references('id')
                ->on('server_info_ids')
                ->onDelete('cascade');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('id_sets');
    }
}
