<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeHighlightedProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'iss_provider_id',
        'sort_order',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(IssProvider::class, 'iss_provider_id');
    }
}

