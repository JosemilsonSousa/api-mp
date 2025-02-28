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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('church_id')->nullable()->defualt(1);
            $table->unsignedBigInteger('subscription_plan_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('last_event_at')->nullable();;
            $table->timestamp('next_charge_at')->nullable();;
            $table->string('status')->nullable();

            $table->timestamps();
                
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subscription_plan_id')->references('id')->on('subscriptions_plans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
