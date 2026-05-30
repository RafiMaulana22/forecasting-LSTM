<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forecastings', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_prediksi');

            $table->decimal('hasil_prediksi', 15, 2);

            $table->string('model')->default('LSTM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecastings');
    }
};
