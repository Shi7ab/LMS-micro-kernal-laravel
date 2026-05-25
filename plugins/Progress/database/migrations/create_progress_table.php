<?php
// plugins/Progress/database/migrations/2026_05_24_000002_create_progress_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_lesson_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('student_id');
            $table->uuid('lesson_id');
            $table->timestamp('completed_at')->useCurrent();

            $table->unique(['student_id', 'lesson_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_lesson_progress');
    }
};
