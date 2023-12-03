<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class garages extends Model
{
    use HasFactory;
    protected $table = "garages";
    protected $fillable = ['id','name', 'numFloors','location','lat','longt','rate','img','desc','price', 'numSpaces'];
}
