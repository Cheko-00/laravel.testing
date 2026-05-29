<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('ticket_number', 20)->unique()->comment('Ej: TKT-00001');
            $table->string('title', 255);
            $table->text('description');

            $table->string('status', 30)->default('open')->comment('open | in_progress | waiting_client | resolved | closed');

            $table->foreignId('category_id')->constrained()->cascadeOnDelete();


            $table->string('priority_level', 20)->default('low')->comment('low | medium | high | critical');

            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('parent_id')->nullable()->constrained('tickets')->nullOnDelete()->comment('sub-ticket o escalación');

            $table->timestamp('due_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            $table->softDeletes(); // deleted_at
            $table->timestamps();  // created_at, updated_at

            // Índices
            $table->index(['status', 'assigned_to']);
            $table->index(['created_by', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
