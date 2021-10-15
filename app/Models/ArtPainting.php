<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ArtPainting extends Model
{
    use HasFactory;
    use Sortable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paintings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'width',
        'height',
        'tecnique',
        'principal_page',
        'art_colection_id',
     ];

     /**
     * The attributes that are sortable
     * 
     * @var array
     */
    public $sortable = ['id', 'name', 'art_colection_id', 'tecnique'];

     /**
     * Get the colection of the painting.
     */
    public function colection()
    {
        return $this->belongsTo(ArtColection::class,'art_colection_id');
    }

    /**
     * Get all the images of the painting.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }
}
