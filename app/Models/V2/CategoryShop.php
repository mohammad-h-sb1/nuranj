<?php

namespace App\Models\V2;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryShop extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shops()
    {
        return  $this->hasMany(Shop::class);
    }
}
