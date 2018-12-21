<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_activations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_client')->unsigned();
            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->string('token');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

        });

        Schema::table('clients', function (Blueprint $table) {
            $table->boolean('is_activated');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients_activations');

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('is_activated');
        });
    }
}
