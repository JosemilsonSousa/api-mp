<?php

namespace App\Models;

use App\Models\Subscribers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoce extends Model
{
    protected $table = 'invoces';

    /**
     *------------------------------------------------------------------------------------------
     * Relationships
     * -----------------------------------------------------------------------------------------
     */

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscribers::class);
    }
}
