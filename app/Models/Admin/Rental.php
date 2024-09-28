<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'total_cost',
        'status',
        'start_date',
        'end_date'
    ];


    public function car(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
