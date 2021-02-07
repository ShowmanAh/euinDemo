<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   // protected $fillable = ['name','image', 'height', 'width', 'description'];
    protected $guarded = [];
    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('uploads/product_images/' . $this->image);
    }

    /*
    public function getImagePathAttribute($val){
        return ($val !== null) ? asset('uploads/product_images/' . $val) : '';
    }
**/
}
