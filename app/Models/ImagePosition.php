<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagePosition extends Model
{
    protected $guarded =[];

    public function image()
    {

        return $this->belongsTo('App\Models\Image', 'image_id');
    }
}
