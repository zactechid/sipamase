<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'role';

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
