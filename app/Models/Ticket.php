<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded=[];

    const BACKEND='backend';
    const FRONT='front';

    const TYPE=[self::BACKEND,self::FRONT];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function img()
    {
        return $this->hasOne(Image::class,'ticket_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


}
