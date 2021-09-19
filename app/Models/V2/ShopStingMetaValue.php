<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopStingMetaValue extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function ShopStingType()
    {
        return $this->belongsTo(ShopStingType::class);
    }
}
