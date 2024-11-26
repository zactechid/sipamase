<?php

namespace App\Models;

use App\Models\pemrakarsa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class uploadfoto extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_foto';
    protected $table = 'uploadfoto';
    protected $guarded = ['id_foto']; 

}
