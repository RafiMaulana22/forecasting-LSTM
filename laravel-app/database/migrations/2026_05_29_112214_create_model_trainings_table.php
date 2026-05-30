<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('model_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_model')->default('LSTM');

            $table->integer('jumlah_data');

            $table->integer('train_split');

            $table->integer('test_split');

            $table->integer('epoch');

            $table->integer('batch_size');

            $table->enum('status', ['success', 'failed'])->default('success');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_trainings');
    }
};
