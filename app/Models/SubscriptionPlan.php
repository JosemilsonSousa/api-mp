<?php

namespace App\Models;

use App\Models\Subscribers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $table = 'subscriptions_plans';
    //protected $fillable = ['name','url','bank_code','bank_name','agency','count' 'church_id'];


    /**
     *------------------------------------------------------------------------------------------
     * Relationships
     * -----------------------------------------------------------------------------------------
     */

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscribers::class);
    } 
}
