<?php

namespace App\Models;

use App\Models\Invoce;
use App\Models\SubscriptionPlan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscriber extends Model
{
    protected $table = 'subscribers';


    /**
     *------------------------------------------------------------------------------------------
     * Relationships
     * -----------------------------------------------------------------------------------------
     */

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function invoces(): HasMany
    {
        return $this->hasMany(Invoce::class);
    }
}
