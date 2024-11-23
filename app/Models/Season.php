<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = ['name','slug','image','is_active'];

    public function product(){
        return $this->hasMany(Product::class);
    }

}
