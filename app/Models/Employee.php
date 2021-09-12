<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded=[];
    const TYPE_EMPLOYEE='employee';
    const TYPE_INTERN='intern';
    const TYPE=[self::TYPE_EMPLOYEE,self::TYPE_INTERN];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
