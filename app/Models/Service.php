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
        return $this->morphMany(Image::class, 'model');
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
       'text',
       'icon_id'
    ];

    /**
     * Get the full decode text.
     *
     * @return string
     */
    public function getTextAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Set the text to json.
     *
     * @param  string  $value
     * @return void
     */
    public function setTextAttribute($value)
    {
        $this->attributes['text'] = json_encode($value);
    }


}
