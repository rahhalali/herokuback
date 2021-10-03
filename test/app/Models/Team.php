<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table ="teams";

    public function employees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Employee::class,'team_id','id');
    }

    public function project()
    {
        return $this->belongsToMany(Project::class,'project_teams','team_id','project_id');
    }
    public function countproject()
    {
        return $this->belongsToMany(Project::class,'project_teams','team_id','project_id');
    }
}
