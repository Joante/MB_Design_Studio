<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'about',
     ];


     /**
     * Get the full decode about.
     *
     * @return string
     */
    public function getAboutAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Set the about to json.
     *
     * @param  string  $value
     * @return void
     */
    public function setAboutAttribute($value)
    {
        $this->attributes['about'] = json_encode($value);
    }
}
