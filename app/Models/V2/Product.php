<?php

namespace App\Models\V2;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];
    const TYPE_PHYSICAL_GOODS='physical_goods';
    const TYPE_DIGITAL_GOODS='digital_goods';
    const TYPE_SERVICE_GOODS='service_goods';
    const TYPE=[self::TYPE_PHYSICAL_GOODS,self::TYPE_DIGITAL_GOODS,self::TYPE_SERVICE_GOODS];

    public function user()
    {
        return $this->belongsTo(User::class,);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function Shopcategories()
    {
        return $this->belongsToMany(ShopCategory::class,'product_shop_category',);
    }

    public function ProductMeta()
    {
        return $this->hasMany(ProductMeta::class);
    }
}
