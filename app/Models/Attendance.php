<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory,SoftDeletes;

    
    protected $fillable = ['worker_id', 'date', 'hours_worked'];

    // Define the relationship with workers
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

}
