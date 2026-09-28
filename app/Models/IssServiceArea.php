<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssServiceArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'iss_provider_id',
        'city',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(IssProvider::class, 'iss_provider_id');
    }
}

