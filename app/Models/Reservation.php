<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'guest_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'total_nights',
        'total_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'total_nights' => 'integer',
            'total_amount' => 'decimal:2',
        ];
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function reservationServices(): HasMany
    {
        return $this->hasMany(ReservationService::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'reservation_services')
            ->withPivot(['id', 'quantity', 'unit_price', 'total_price'])
            ->withTimestamps();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments->where('payment_status', 'paid')->sum('amount');
    }

    public function getBalanceDueAttribute(): float
    {
        $due = (float) $this->total_amount - $this->total_paid;
        return $due > 0 ? round($due, 2) : 0.00;
    }

    public function getIsFullyPaidAttribute(): bool
    {
        return $this->balance_due <= 0.001;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status', ['checked_out', 'cancelled']);
    }

    public function scopeArrivalsToday(Builder $query): Builder
    {
        return $query->whereDate('check_in_date', Carbon::today());
    }

    public function scopeDeparturesToday(Builder $query): Builder
    {
        return $query->whereDate('check_out_date', Carbon::today());
    }
}
