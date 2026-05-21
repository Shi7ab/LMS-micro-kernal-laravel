<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {

        Schema::create('enrollments', function (Blueprint $table) {
            // 1. UUID
            $table->uuid('id')->primary();


            $table->uuid('course_id')->index();
            $table->uuid('student_id')->index();

            $table->enum('status', ['active', 'completed', 'dropped'])
                  ->default('active')
                  ->index();

            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            /**
             * 5. (Unique Composite Index)
             * to make sure didn't take same course id
             **/
            $table->unique(['course_id', 'student_id']);
        });
    }

    /**
     *  back down
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
