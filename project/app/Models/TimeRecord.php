<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeRecord extends Model
{
    protected $fillable = [
        'public_id','employee_id' ,'recorded_at', 'type','description'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
