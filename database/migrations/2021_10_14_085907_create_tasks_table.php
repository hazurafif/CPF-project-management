<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('pic')->nullable();
            $table->date('start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('end')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('delay')->nullable()->default(null);
            $table->text('description')->nullable();
            $table->text('picdescription')->nullable();
            $table->string('file')->nullable();
            $table->string('picfile')->nullable();
            $table->enum('status', ['Ongoing', 'Delayed', 'Finished'])->default('Ongoing');
            $table->timestamps();
            $table->bigInteger('user_id')->nullable()->default(null)->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('tasks');
    }
}
