<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use HasFactory;
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'text',
        'principal_page',
        'principal_image',
        'category_id'
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
     * The attributes that are sortable
     * 
     * @var array
     */
    public $sortable = ['id', 'title', 'category_id', 'principal_page'];


    /**
     * Get the category that owns the post.
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Obtener todas las fotos del servicio.
     */
    public function images()
    {
        return $this->morphOne(Image::class, 'model');
    }


    /**
     * Get the principal image of the post.
     */
    public function principal_image()
    {
        return $this->hasOne(Image::class,'principal_image');
    }

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
     * Get the formated created date.
     *
     * @return string
     */
    public function getCreated_atAttribute($value)
    {
        return $value->format('d-m-Y');
    }
     
}
