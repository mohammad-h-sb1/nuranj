<?php

namespace App\Models\V2;

use App\Models\User;
use App\Models\V2\Shop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function parent()
    {
        return  $this->belongsTo(ShopCategory::class,'parent_id','id');
    }

    public function Children()
    {
        return $this->hasMany(ShopCategory::class ,'parent_id','id');
    }

    public function Products()
    {
        return $this->belongsToMany(Product::class,'product_shop_category',);
    }
}
