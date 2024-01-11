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
        Schema::create('drivers_trips', function (Blueprint $table) {
            $table->bigIncrements('id');;
            $table->foreignId('driver_id')->index();
            $table->timestamp('pickup')->nullable();
            $table->timestamp('dropoff')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers_trips');
    }
};
