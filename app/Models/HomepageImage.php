<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'hierarchy',
     ];
 

    /**
     * Obtener todas las fotos de.
     */
    public function images()
    {
        return $this->morphOne(Image::class, 'model');
    }
}
