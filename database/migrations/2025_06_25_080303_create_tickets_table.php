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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('category', ['konten_tidak_pantas', 'menghapus_index', 'lainnya']);
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->string('site_link')->nullable();
            $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
            $table->string('attachment')->nullable();
            $table->enum('status', ['submitted', 'in_progress', 'done', 'rejected'])->default('submitted');
            $table->text('description')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->softDeletes(); // adds deleted_at
            $table->timestamps();

            $table->index(['ticket_number', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
