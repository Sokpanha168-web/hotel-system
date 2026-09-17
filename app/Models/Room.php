<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type_id',
        'status',
        'image',
        'floor',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->attributes['image'])) {
            return str_starts_with($this->attributes['image'], 'http') 
                ? $this->attributes['image'] 
                : asset('storage/' . $this->attributes['image']);
        }

        if ($this->relationLoaded('roomType') && !empty($this->roomType?->image)) {
            return str_starts_with($this->roomType->image, 'http') 
                ? $this->roomType->image 
                : asset('storage/' . $this->roomType->image);
        }

        return 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80';
    }

    protected function casts(): array
    {
        return [
            'floor' => 'integer',
        ];
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    public function scopeOccupied(Builder $query): Builder
    {
        return $query->where('status', 'occupied');
    }

    public function scopeCleaning(Builder $query): Builder
    {
        return $query->where('status', 'cleaning');
    }

    public function scopeMaintenance(Builder $query): Builder
    {
        return $query->where('status', 'maintenance');
    }

    public function scopeFloor(Builder $query, int $floor): Builder
    {
        return $query->where('floor', $floor);
    }
}
