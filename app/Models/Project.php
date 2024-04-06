<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Project extends Model
{
    use HasFactory;
    use Sortable;


    /**
     * The attributes that are sortable
     * 
     * @var array
     */
    public $sortable = ['id', 'title', 'service_id', 'client', 'area'];
   
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'principal_page' => 'boolean',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'client', 'location', 'service_id', 'principal_page', 'area'];

    /**
     * Get the full decode description.
     *
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Set the description to json.
     *
     * @param  string  $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = json_encode($value);
    }

    /**
     * Get the service that owns the project.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Obtener todas las fotos del servicio.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'model')->orderBy('hierarchy');
    }
}
