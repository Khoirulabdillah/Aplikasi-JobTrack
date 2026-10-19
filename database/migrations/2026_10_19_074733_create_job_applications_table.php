<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('job_position');
            $table->string('job_location')->nullable();
            $table->string('employment_type');
            $table->string('work_arrangement');
            $table->date('application_date');
            $table->string('source');
            $table->string('job_url')->nullable();
            $table->string('recruiter_name')->nullable();
            $table->string('recruiter_email')->nullable();
            $table->string('status')->default('Dikirim');
            $table->decimal('expected_salary', 15, 2)->nullable();
            $table->date('follow_up_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('company_name');
            $table->index('job_position');
            $table->index('status');
            $table->index('application_date');
            $table->index('follow_up_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
