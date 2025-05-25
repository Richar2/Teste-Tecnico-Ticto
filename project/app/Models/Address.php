<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'zip_code', 'street', 'neighborhood', 'city', 'state', 'complement'
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
