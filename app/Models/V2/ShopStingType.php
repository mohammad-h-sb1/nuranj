<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopStingType extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function shopSting()
    {
        return $this->belongsTo(ShopSting::class);
    }

    public function Shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function shopStingMetaValues()
    {
        return $this->hasMany(ShopStingMetaValue::class);
    }
}
