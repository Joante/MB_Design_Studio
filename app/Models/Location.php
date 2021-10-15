<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Location extends Model
{
    use HasFactory;
    use Sortable;

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
     * The attributes that are sortable
     * 
     * @var array
     */
    public $sortable = ['id', 'name', 'url', 'phone', 'adress'];


    /**
     * Get the image of the location.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'model');
    }
}
