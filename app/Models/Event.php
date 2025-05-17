<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia; // Import HasMedia
use Spatie\MediaLibrary\InteractsWithMedia; // Import InteractsWithMedia

class Event extends Model implements HasMedia // Implement HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia; // Use InteractsWithMedia

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'venue',
        'available_seats',
        'price',
        'category_id',
        'is_featured',
        'capacity',
        'image'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Add this method if you need to register media collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('events');
    }

    // Add this method to check if booking is possible (optional, based on your logic)
    public function getCanBookAttribute()
    {
        // Example logic: booking is possible if date is in the future and seats are available
        return $this->date >= now()->startOfDay() && $this->available_seats > 0;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>', now());
    }
}
