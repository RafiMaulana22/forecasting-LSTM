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
        Schema::table('forecastings', function (Blueprint $table) {
            $table->integer('epoch')->nullable();

            $table->double('loss', 15, 8)->nullable();

            $table->longText('loss_history')->nullable();

            $table->double('mae', 15, 4)->nullable();

            $table->double('rmse', 15, 4)->nullable();

            $table->double('mape', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forecastings', function (Blueprint $table) {
            //
        });
    }
};
