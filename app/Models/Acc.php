<?php

namespace App\Models;

use App\Enums\AccKind;
use Illuminate\Database\Eloquent\Model;

class Acc extends Model
{
    protected $casts=['kind'=>AccKind::class,];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
