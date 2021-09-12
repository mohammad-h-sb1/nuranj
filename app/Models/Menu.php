<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded=[];

    const HEADER='header';
    const FOOTER='footer';
    const PLACE=[self::HEADER,self::FOOTER];

    public function parent()
    {
        return  $this->belongsTo(Menu::class,'parent_id','id');
    }

    public function Children()
    {
        return $this->hasMany(Menu::class ,'parent_id','id');
    }
}
