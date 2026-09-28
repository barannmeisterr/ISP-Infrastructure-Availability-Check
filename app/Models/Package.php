<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'iss_provider_id',
        'title',
        'xdsltype',
        'download',
        'upload',
        'price',
        'commitment',
        'commitment_month',
        'quota',
        'ping',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'commitment' => 'bool',
        'quota' => 'bool',
        'xdsltype'   => 'int',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(IssProvider::class, 'iss_provider_id');
    }


    public function areas(): HasMany
    {
        return $this->hasMany(PackageArea::class);
    }

}

