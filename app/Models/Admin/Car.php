<?php

namespace App\Models\Admin;

use Hamcrest\Type\IsBoolean;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'year',
        'car_type',
        'daily_rent_price',
        'availability',
        'image'
    ];

    protected $attributes = [
        'availability' => true,
    ];


    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
    public function active_rent(): HasMany
    {
        return $this->hasMany(Rental::class)->where(function ($query) {

            $query->where('status', 'Ongoing')
                ->orWhere('status', 'Booked');
        });
    }
}
