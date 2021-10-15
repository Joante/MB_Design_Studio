<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ArtColection extends Model
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
        'description',
        'principal_page'
    ];

    /**
     * The attributes that are sortable
     * 
     * @var array
     */
    public $sortable = ['id', 'name', 'description', 'principal_page'];

    /**
     * Get the image of the colection.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'model');
    }
}
