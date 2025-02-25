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
        Schema::create('invoces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscriber_id')->nullable();

            $table->string('payment_method_id')->nullable();
            $table->string('payment_type_id')->nullable();
            $table->string('currency_id')->nullable();
            $table->string('description')->nullable();
            $table->string('taxes_amount')->nullable();
            $table->string('shipping_amount')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('payer_identification_number')->nullable();
            $table->string('payer_identification_type')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('statement_descriptor')->nullable();

            $table->decimal('transaction_amount',8,2)->nullable();
            $table->decimal('net_received_amount',8,2)->nullable();
            $table->decimal('total_paid_amount',8,2)->nullable();

            $table->timestamp('date_created')->nullable();
            $table->timestamp('date_approved')->nullable();
            $table->timestamp('date_last_updated')->nullable();

            $table->longText('notification_url')->nullable();
            $table->longText('qr_code_base64')->nullable();
            $table->longText('qr_code')->nullable();
            $table->longText('ticket_url')->nullable();

            $table->timestamps();

            $table->foreign('subscriber_id')
                ->references('id')
                ->on('subscribers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoces');
    }
};
