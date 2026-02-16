<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
             $table->engine = 'InnoDB';
            $table->id();

            // booking can be for clinic OR procedure
            $table->enum('booking_type', ['clinic', 'procedure']);

            $table->foreignId('clinic_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('procedure_id')->nullable()->constrained()->nullOnDelete();

            // schedule (date + time)
            $table->dateTime('scheduled_at');

            // booking tracking
            $table->string('booking_code', 40)->unique();
            $table->enum('status', ['pending', 'confirmed', 'done', 'cancelled', 'no_show'])->default('pending');

            // patient details (your fields)
            $table->string('patient_name');
            $table->unsignedTinyInteger('patient_age')->nullable();
            $table->enum('patient_gender', ['male', 'female', 'other'])->nullable();
            $table->text('patient_diagnosis')->nullable();
            $table->string('patient_home_address')->nullable();
            $table->string('patient_next_of_kin')->nullable();
            $table->string('patient_phone', 30);
            $table->string('patient_email')->nullable();

            $table->timestamps();

            // helpful indexes
            $table->index(['booking_type', 'scheduled_at']);
            $table->index(['status', 'scheduled_at']);
            $table->index('patient_phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
