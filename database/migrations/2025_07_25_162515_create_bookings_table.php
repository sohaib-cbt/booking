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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->enum('booking_form_type', ['centre_home_community', 'school', 'fsp_csp']); // Required

            // for school
            $table->enum('entry_type', ['school', 'pre_school'])->nullable();
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
            $table->string('private_room_area')->nullable();
            $table->string('specific_time')->nullable();
            $table->string('other_app_scheduling_info')->nullable();
            $table->string('days_off_week')->nullable();

            // fsp/csp
            $table->boolean('child_attend')->default(0)->nullable();
            $table->string('schedule_by')->nullable();
            $table->longText('internal_team')->nullable();
            $table->longText('external_team')->nullable();
            $table->string('length_of_metting')->nullable();
            $table->longText('follow_up_meeting')->nullable();

            // common
            $table->string('client_name')->nullable();
            $table->enum('language', ['english', 'french'])->default('english')->nullable();
            $table->enum('priority', ['normal', 'medium', 'high', 'urgent'])->default('normal')->nullable();
            $table->boolean('reminder_call')->default(0)->nullable();
            $table->string('alayacare_type')->nullable()->comment('ax/reax', 'cc', 'csp-cc', 'fa', 'id', 'n/a', 'scd', 'tel/ema', 'virt-ax', 'virt-cc', 'virt-fa', 'virt-id');
            $table->string('alayacare_service_code')->nullable();
            $table->boolean('room_setup')->default(0)->nullable();
            $table->string('units_from')->nullable()->comment('5 hr', '1 hr', '1.5 hr', '15 min', '2 hr', '2.5 hr', '3 hr', '45 min', 'n/a');
            $table->string('units_to')->nullable()->comment('5 hr', '1 hr', '1.5 hr', '15 min', '2 hr', '2.5 hr', '3 hr', '45 min', 'n/a');
            $table->string('trvel_time')->nullable();
            $table->string('area_of_town')->nullable()->comment('central', 'east', 'west');
            $table->longText('rooms')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('therapist_id')->nullable()->constrained('therapists')->onDelete('cascade');
            $table->longText('inform_to')->nullable();
            $table->string('report_time')->nullable()->comment('5 hr', '1 hr', '1.5 hr', '15 min', '2 hr', '2.5 hr', '3 hr', '45 min', 'n/a');
            $table->string('reoccur_app_info')->nullable();
            $table->string('comments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
