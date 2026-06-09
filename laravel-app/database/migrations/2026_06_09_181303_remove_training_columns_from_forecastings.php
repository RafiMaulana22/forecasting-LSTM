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
            $table->dropColumn(['epoch', 'loss', 'loss_history', 'mae', 'rmse', 'mape']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forecastings', function (Blueprint $table) {
            $table->integer('epoch')->nullable();

            $table->double('loss')->nullable();

            $table->longText('loss_history')->nullable();

            $table->double('mae')->nullable();

            $table->double('rmse')->nullable();

            $table->double('mape')->nullable();
        });
    }
};
