<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'phone',
        'adress',
    ];

    /**
     * Get the image of the location.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'model');
    }
}
