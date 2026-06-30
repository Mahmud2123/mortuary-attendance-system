<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bodies', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->unique();
            $table->string('full_name');
            $table->integer('age')->nullable();
            $table->enum('sex', ['male', 'female', 'unknown'])->default('unknown');
            $table->string('nationality')->default('Nigerian');
            $table->date('date_of_death')->nullable();
            $table->time('time_of_death')->nullable();
            $table->string('cause_of_death')->nullable();
            $table->string('place_of_death')->nullable();
            $table->foreignId('admitted_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('chamber_id')->nullable()->constrained('chambers')->onDelete('set null');
            $table->enum('status', ['admitted', 'in_storage', 'released', 'transferred'])->default('admitted');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('bodies'); }
};
