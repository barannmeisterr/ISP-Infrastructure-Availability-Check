<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IssProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo_path',
        'location',
        'services',
        'company_info',
        'cagrimerkezi',
        'whatsapp_no',
        'fax',
        'email',
        'website',
        'unvan',
        'address',
    ];

    protected $casts = [
        'services' => 'array',
    ];

    public function serviceAreas(): HasMany
    {
        return $this->hasMany(IssServiceArea::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}

