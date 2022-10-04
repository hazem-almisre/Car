<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Car extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'name_id',
        'model',
        'color',
        'description',
        'vendor_id',
    ];

    protected $hidden =[
        'name_id',
        'vendor_id'
    ];

    public function likes()
    {
        return $this->hasMany(Like::class, 'car_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function iamages()
    {
        return $this->hasMany(Image::class, 'car_id', 'id');
    }


    public function carName()
    {
        return $this->belongsTo(CarName::class, 'name_id', 'id');
    }

}
