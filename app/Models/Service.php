<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * Obtener todas las fotos del servicio.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'getImages');
    }

    /**
     * Obtener el icono que pertenece al servicio.
     */
    public function icon()
    {
        return $this->belongsTo(Icon::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'title',
       'description',
       'icon_id'
    ];



}
