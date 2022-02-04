<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id_to');
            $table->integer('user_id_from');
            $table->integer('status')->default(0);
            $table->timestamp('requested_at');
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();

            // add unique index
            $table->unique(['user_id_to', 'user_id_from']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
