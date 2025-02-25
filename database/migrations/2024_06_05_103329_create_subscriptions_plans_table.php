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
        Schema::create('subscriptions_plans', function (Blueprint $table) {
            $table->id();
            $table->string('preapproval_plan_id')->nullable();
            $table->string('back_url')->nullable();
            $table->bigInteger('collector_id')->nullable();
            $table->bigInteger('application_id')->nullable();
            $table->string('reason')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('date_created')->nullable();
            $table->timestamp('last_modified')->nullable();
            $table->longText('init_point')->nullable();
            $table->string('frequency')->nullable();
            $table->string('frequency_type')->nullable();
            $table->string('repetitions')->nullable();
            $table->string('billing_day')->nullable();
            $table->string('billing_day_proportional')->nullable();
            $table->string('free_trial_frequency')->nullable();
            $table->string('free_trial_frequency_type')->nullable();
            $table->decimal('transaction_amount',8,2)->nullable();
            $table->string('currency_id')->nullable();
            $table->string('payment_methods')->nullable();
            $table->string('external_reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions_plans');
    }
};
