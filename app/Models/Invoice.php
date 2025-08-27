<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function Bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
