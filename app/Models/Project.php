<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    const LEVEL_ANALYSIS='analysis';
    const LEVEL_LABOR_RELATIONS='laborRelations';
    const LEVEL_CODING='coding';
    const LEVEL_TEST='test';

    const LEVELS=[self::LEVEL_ANALYSIS,self::LEVEL_LABOR_RELATIONS,self::LEVEL_CODING,self::LEVEL_TEST];

    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function workTeams()
    {
        return $this->belongsToMany(WorkTeam::class,'project_work',);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }


}
