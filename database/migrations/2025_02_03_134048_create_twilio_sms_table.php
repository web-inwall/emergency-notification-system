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
        Schema::create('twilio_sms', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('sid', 500);
            $table->enum('direction', ['sent', 'received']);
            $table->string('from', 50);
            $table->string('to', 50);
            $table->string('body', 1600)->nullable()->default(null);
            $table->enum('status', ['request_error', 'accepted', 'queued', 'sending', 'sent', 'receiving', 'received', 'delivered', 'undelivered', 'failed', 'read'])->default('request_error');

            // Indexes
            $table->unique(['sid']);
            $table->index(['from']);
            $table->index(['to']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twilio_sms');
    }
};
