<?php

namespace App\Models;

use App\Models\Invoce;
use App\Models\SubscriptionPlan;
use App\Models\User;

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


    public function invoces(): HasMany
    {
        return $this->hasMany(Invoce::class);
    }
    
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class,'subscription_plan_id');
    }    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
