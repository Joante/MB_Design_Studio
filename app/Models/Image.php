<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected static $isUpdate;

    protected static $newModel;

    /**
     * Get the parent commentable model (post or video).
     */
    public function images()
    {
        return $this->morphTo();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'location',
        'model_type',
        'model_id',
        'hierarchy'
     ];

    
     /**
      * Hierarchy events
      */
      protected static function booted()
    {
        static::updating(function ($image) {
            $newHierarchy = $image->hierarchy;
            $oldHierarchy = $image->getOriginal('hierarchy');
            if(self::$isUpdate && $oldHierarchy != $newHierarchy) {
                Image::where('id', $image->id)
                    ->update(['hierarchy' => -1]);
                
                if ($newHierarchy > $oldHierarchy) {
                    Image::where('model_type', $image->model_type)
                        ->where('model_id', $image->model_id)
                        ->whereBetween('hierarchy', [$oldHierarchy + 1, $newHierarchy])
                        ->where('id', '!=', $image->id)
                        ->orderBy('hierarchy', 'asc')
                        ->decrement('hierarchy');
                } else {
                    Image::where('model_type', $image->model_type)
                        ->where('model_id', $image->model_id)
                        ->whereBetween('hierarchy', [$newHierarchy, $oldHierarchy - 1])
                        ->where('id', '!=', $image->id)
                        ->orderBy('hierarchy', 'desc')
                        ->increment('hierarchy');
                }
            }
        });

        static::creating(function ($image) {
            if(!self::$newModel) {
                $newHierarchy = $image->hierarchy;
                Image::where('model_type', $image->model_type)
                    ->where('model_id', $image->model_id)
                    ->where('hierarchy', '>=', $newHierarchy)
                    ->orderBy('hierarchy', 'desc')
                    ->increment('hierarchy');
            }
        });

        static::deleted(function ($model) {
            $image = $model->getOriginal();

            Image::where('model_type', $image['model_type'])
                ->where('model_id', $image['model_id'])
                ->where('hierarchy', '>', $image['hierarchy'])
                ->orderBy('hierarchy', 'asc')
                ->decrement('hierarchy');
        });
    }

    public static function setIsUpdate($isUpdate){
        self::$isUpdate = $isUpdate;
    }

    public static function setNewModel($newModel){
        self::$newModel = $newModel;
    }
}
