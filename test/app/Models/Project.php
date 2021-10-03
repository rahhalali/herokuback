<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table="projects";
    /**
     * @var mixed
     */
    protected $fillable =[
        'project_name'
    ];

    public function team()
    {
        return $this->belongsToMany(Team::class,'project_teams','project_id','team_id');
    }

}
