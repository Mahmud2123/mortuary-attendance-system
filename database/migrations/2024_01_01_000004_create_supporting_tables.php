<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Next of Kins
        Schema::create('next_of_kins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('body_id')->constrained('bodies')->onDelete('cascade');
            $table->string('full_name');
            $table->string('relationship');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });

        // Body Chamber Assignments
        Schema::create('body_chamber_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('body_id')->constrained('bodies')->onDelete('cascade');
            $table->foreignId('chamber_id')->constrained('chambers')->onDelete('cascade');
            $table->timestamp('assigned_at');
            $table->timestamp('vacated_at')->nullable();
            $table->timestamps();
        });

        // Attendance Logs
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('clock_in');
            $table->timestamp('clock_out')->nullable();
            $table->decimal('duration_hours', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Body Releases
        Schema::create('body_releases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('body_id')->constrained('bodies')->onDelete('restrict');
            $table->foreignId('released_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('kin_id')->nullable()->constrained('next_of_kins')->onDelete('set null');
            $table->date('release_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Audit Logs
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action'); // create, update, delete
            $table->string('table_name');
            $table->unsignedBigInteger('record_id')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('body_releases');
        Schema::dropIfExists('attendance_logs');
        Schema::dropIfExists('body_chamber_assignments');
        Schema::dropIfExists('next_of_kins');
    }
};
