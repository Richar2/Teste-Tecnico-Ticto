<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Employee extends Authenticatable
{
    use HasApiTokens,  Notifiable;    
    
    protected $fillable = [
        'name', 'cpf', 'email', 'password', 'position', 'birth_date', 'administrator_id'
    ];

    protected static function booted()
    {
        static::creating(function ($employee) {
            $employee->public_id = (string) Str::uuid();
        });
    }
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
