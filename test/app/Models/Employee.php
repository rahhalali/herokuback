<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    use HasFactory;

    protected $table="employees";

    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class ,'team_id','id');
    }
    public function kpiEm()
    {
        return $this->belongsToMany(Employee_Kpi::class,'employee_id','id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id','id');
    }
    public function KPI()
    {
        return $this->belongsToMany(KPI::class,'employee_kpis','employee_id','kpi_id')->distinct();
    }

}
