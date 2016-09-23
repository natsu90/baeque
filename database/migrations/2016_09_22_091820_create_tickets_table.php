<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Carbon\Carbon;
class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('premise_id');
            $table->integer('activity_id');
            $table->boolean('served')->default(false);

            $table->boolean('done')->default(false);
            $table->integer('queue_id');
            $table->datetime('served_time')->default(Carbon::now());
            $table->datetime('done_time')->default(Carbon::now());
            $table->integer('serving_counter')->default(false);
            $table->string('invite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tickets');
    }
}
