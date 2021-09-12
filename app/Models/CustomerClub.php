<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerClub extends Model
{
    use HasFactory;
    protected $guarded=[];

    const TYPE_MANAGER='type_manager';
    const TYPE_CUSTOMER='type_customer';
    const TYPE=[self::TYPE_MANAGER,self::TYPE_CUSTOMER];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customerClubLog()
    {
        return $this->hasMany(CustomerClubLog::class);
    }
}
