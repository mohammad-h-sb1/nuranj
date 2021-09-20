<?php

namespace App\Models\V2;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketProduct extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function Products()
    {
        return $this->belongsToMany(Product::class,'product_ticket','ticket_product_id','product_id','');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
