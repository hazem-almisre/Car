<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'image_url',
        'car_id',

    ];

    protected $hidden =[
        'car_id',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'carr_id', 'id');
    }

}
