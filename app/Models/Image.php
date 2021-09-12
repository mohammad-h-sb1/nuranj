<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function wortTeam()
    {
        return $this->belongsTo(WorkTeam::class,'work_team_id','id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class,'pro_id','id');

    }
    public function page()
    {
        return $this->belongsTo(Page::class,);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
