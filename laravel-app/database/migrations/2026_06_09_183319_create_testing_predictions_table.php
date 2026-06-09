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
        Schema::create('testing_predictions', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();

            $table->double('aktual');

            $table->double('prediksi');

            $table->double('selisih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testing_predictions');
    }
};
