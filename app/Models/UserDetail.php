<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPUnit\Framework\returnSelf;

class UserDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'first_name',
        'second_name',
        'first_surname',
        'second_surname',
        'second_email',
        'cell_phone',
        'landline',
        'address',
        'workplace',
        'position',
        'description',
        'country_id',
        'role',
    ];

    public function fullName() {
        return "{$this->first_name} {$this->first_surname}";
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function country() {
        return $this->belongsTo(Country::class,'country_id');
    }
}
