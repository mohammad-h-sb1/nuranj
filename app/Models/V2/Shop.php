<?php

namespace App\Models\V2;

use App\Models\User;
use App\Models\V2\ShopCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoryShop()
    {
        return $this->belongsTo(CategoryShop::class);
    }

    public function scopeExpired_at($query)
    {
        return  $query->where('expired_at','>',now());
    }

    public function ShopMeta()
    {
        return $this->hasOne(ShopMeta::class);
    }

    public function shopCategories()
    {
        return $this->hasMany(ShopCategory::class);
    }

    public function shopStings()
    {
        return $this->hasMany(ShopSting::class);
    }

    public function ShopStingTypes()
    {
        return $this->hasMany(ShopStingType::class);
    }

    public function Products()
    {
        return $this->hasMany(Product::class);
    }
}
