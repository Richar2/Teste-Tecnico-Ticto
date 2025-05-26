<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{
   
    use HasApiTokens, Notifiable;
   
    protected $fillable = [
        'name', 'cpf', 'email', 'password', 'birth_date'
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
