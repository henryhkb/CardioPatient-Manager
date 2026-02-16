<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
             $table->engine = 'InnoDB';
            $table->id();

            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();

            $table->dateTime('reminder_at');
            $table->enum('channel', ['sms', 'whatsapp', 'email']);
            $table->text('message');

            $table->enum('status', ['queued', 'sent', 'failed'])->default('queued');
            $table->dateTime('sent_at')->nullable();
            $table->text('failure_reason')->nullable();

            $table->timestamps();

            $table->index(['status', 'reminder_at']);
            $table->index(['channel', 'reminder_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
