<?php

namespace App\Models;

use App\Enums\Kind;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $casts=['kind'=>Kind::class,];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
