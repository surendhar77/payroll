<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name', 'employee_id', 'contact_details', 'salary_type'];

    // Define the relationship with attendance records
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
