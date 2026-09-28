<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'il_id',
        'ilce_id',
        'mahalle_id',
        'csbm_id',
        'bina_id',
        'city',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}

