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
        Schema::create('air_conditioners', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equipment_id')->constrained('equipments')->cascadeOnDelete();

            $table->decimal('capacity_tr', 6, 2);
            $table->enum('type', ['split', 'window', 'package']); // split, window, package, etc
            $table->string('model');
            $table->string('brand');
            $table->string('refrigerant');
            $table->string('serial_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_conditioners');
    }
};
