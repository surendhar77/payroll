<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkersWages extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['monthly_salary', 'worker_id', 'weekly_salary', 'salary_type'];
    
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
