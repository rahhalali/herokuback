<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPI extends Model
{
    use HasFactory;
    protected $table="kpis";

    public function employee_kpi(){
        return $this->hasMany(Employee_Kpi::class,'kpi_id','id');
    }

    public function employees(){
        return $this->belongsToMany(Employee::class,'employee_kpis','kpi_id','employee_id');
    }

//    //------> done
    public function last_price()
    {
        return $this->hasOne(Employee_Kpi::class,'kpi_id','id')->distinct()->latest();
    }



}
