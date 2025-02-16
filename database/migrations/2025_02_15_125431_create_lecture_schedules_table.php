<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lecture_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecture_id')->constrained();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('venue')->nullable();
            $table->text('notes')->nullable();
            $table->enum('type', ['physical', 'online']);
            $table->string('meeting_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecture_schedules');
    }
};