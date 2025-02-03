<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('twilio_sms_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('twilio_sms_id')->unsigned()->nullable()->default(null);
            $table->string('sms_sid', 500)->nullable()->default(null);
            $table->string('sms_message_sid', 500)->nullable()->default(null);
            $table->enum('event', ['send_sms_request',
                'send_sms_request_error',
                'message_received',
                'segment_status_changed',
                'status_changed',
                'invalid_request_sid_not_defined',
                'twilio_sms_not_found',
                'generic_error',
                'not_categorized'])->default('not_categorized');
            $table->string('new_status', 191)->nullable()->default(null);
            $table->json('details')->nullable()->default(null);
            $table->timestamps();

            // Indexes
            $table->index(['twilio_sms_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twilio_sms_logs');
    }
};
