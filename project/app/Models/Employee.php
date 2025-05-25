<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'cpf', 'email', 'password', 'position', 'birth_date', 'administrator_id'
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function timeRecords()
    {
        return $this->hasMany(TimeRecord::class);
    }
}
