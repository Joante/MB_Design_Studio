<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Service extends Model
{
    use HasFactory;
    use Sortable;

    /**
     * The attributes that are sortable
     * 
     * @var array
     */
    public $sortable = ['id', 'title', 'description'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'title',
       'description',
       'text',
       'principal_page',
       'icon_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'principal_page' => 'boolean',
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

    /**
     * Obtener todas las fotos del servicio.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'model')->orderBy('hierarchy');
    }

    /**
     * Obtener el icono que pertenece al servicio.
     */
    public function icon()
    {
        return $this->belongsTo(Icon::class);
    }


}
