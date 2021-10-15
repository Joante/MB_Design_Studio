<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ArtExhibition extends Model
{
    use HasFactory;
    use Sortable;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exhibitions';

    protected $dates = ['date_start', 'date_finish'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'text',
        'description',
        'principal_page',
        'date_start',
        'date_finish',
        'hour_start',
        'hour_finish',
        'location_id'
     ];
 
     /**
      * The attributes that should be cast.
      *
      * @var array
      */
     protected $casts = [
         'principal_page' => 'boolean',
         'hour_start' => 'datetime:H:i',
         'hour_finish' => 'datetime:H:i',
     ];

     /**
     * The attributes that are sortable
     * 
     * @var array
     */
    public $sortable = ['id', 'title', 'location_id', 'principal_page', 'date_start', 'date_finish'];

    /**
     * Get the location of the exhibition.
     */
    public function location()
    {
        return $this->belongsTo(Location::class,'location_id');
    }

    /**
     * Get all the images of the exhibition.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'model');
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
}
