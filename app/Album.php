<?php

namespace App;

use App\Image;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['name'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
