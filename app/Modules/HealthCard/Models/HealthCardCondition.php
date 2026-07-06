<?php

namespace App\Modules\HealthCard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthCardCondition extends Model
{
    use HasFactory;

    protected $table = 'health_card_conditions';

    protected $fillable = [
        'health_card_id',
        'name',
        'description',
        'is_emergency_enabled',
        'sort_order',
    ];

    protected $casts = [
        'is_emergency_enabled' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function healthCard(): BelongsTo
    {
        return $this->belongsTo(HealthCard::class, 'health_card_id');
    }

    public function medicalReports(): HasMany
    {
        return $this->hasMany(MedicalReport::class, 'condition_id');
    }
}
