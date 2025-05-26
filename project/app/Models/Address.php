<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Address extends Model
{
    protected $fillable = [
        'zip_code', 'street', 'neighborhood', 'city', 'state', 'complement'
    ];

    protected static function booted()
    {
        static::creating(function ($employee) {
            $employee->public_id = (string) Str::uuid();
        });
    }
    public function addressable()
    {
        return $this->morphTo();
    }
}
