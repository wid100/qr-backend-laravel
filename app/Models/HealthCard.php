<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class HealthCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'card_number',
        'qr_code',
        'barcode',
        'card_image_path',
        'is_active',
        'issued_at',
        'expires_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    // Helper methods
    public static function generateCardNumber(): string
    {
        do {
            $cardNumber = 'HC' . date('Y') . strtoupper(Str::random(8));
        } while (self::where('card_number', $cardNumber)->exists());

        return $cardNumber;
    }

    public static function generateQRCode(): string
    {
        do {
            $qrCode = 'QR' . time() . strtoupper(Str::random(6));
        } while (self::where('qr_code', $qrCode)->exists());

        return $qrCode;
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getQRCodeData(): array
    {
        return [
            'card_number' => $this->card_number,
            'patient_id' => $this->patient->patient_id,
            'patient_name' => $this->patient->full_name,
            'issued_at' => $this->issued_at->toISOString(),
            'expires_at' => $this->expires_at?->toISOString(),
        ];
    }
}
