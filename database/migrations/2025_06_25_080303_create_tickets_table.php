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

            // Jika kamu tidak menggunakan Auth::user(), maka kolom user_id bisa dihapus.
            // $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            $table->enum('category', [
                'konten_tidak_pantas',
                'menghapus_index',
                'pornografi',
                'judi_online',
                'lainnya'
            ]);

            $table->enum('priority', ['low', 'medium', 'high']);
            $table->string('site_link')->nullable();

            // Ganti faculty_id menjadi manual input: faculty_name / okupasi
            $table->string('faculty_name');

            $table->string('email');
            $table->string('attachment')->nullable();
            $table->enum('status', ['submitted', 'in_progress', 'done', 'rejected'])->default('submitted');
            $table->text('description')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->softDeletes();
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
