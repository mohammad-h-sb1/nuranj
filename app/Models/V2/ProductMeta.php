<?php

namespace App\Models\V2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
