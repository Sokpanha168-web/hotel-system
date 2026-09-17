<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'capacity',
        'amenities',
        'image',
    ];

    public function getImageUrlAttribute(): string
    {
        // Only check rooms if already loaded to avoid triggering database queries during serialization
        if ($this->relationLoaded('rooms') && $this->rooms) {
            $roomWithImage = $this->rooms->first(fn($r) => !empty($r->image));
            if ($roomWithImage && !empty($roomWithImage->image)) {
                return str_starts_with($roomWithImage->image, 'http') 
                    ? $roomWithImage->image 
                    : asset('storage/' . $roomWithImage->image);
            }
        }

        if (!empty($this->attributes['image'])) {
            return str_starts_with($this->attributes['image'], 'http') 
                ? $this->attributes['image'] 
                : asset('storage/' . $this->attributes['image']);
        }

        return 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80';
    }

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'capacity' => 'integer',
            'amenities' => 'array',
        ];
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function reservations(): HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, Room::class);
    }
}
