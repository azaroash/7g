<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('user_activations', function (Blueprint $table) {
        //     $table->integer('user_id')->unsigned();
        //     $table->string('token')->index();
        //     $table->timestamp('created_at');
        // });
        Schema::create('user_activations', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('token');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

        });

        Schema::table('users', function (Blueprint $table) {

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
        //Schema::dropIfExists('user_activations');
        Schema::drop("user_activations");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_activated');
        });
    }
}
