<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function userDetail() {
        return $this->hasMany(UserDetail::class,'country_id');
    }
}
