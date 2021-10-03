<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_Kpi extends Model
{
    use HasFactory;
    protected $table='employee_kpis';

    public function kpis(){
        return $this->belongsTo(KPI::class,'kpi_id','id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}
