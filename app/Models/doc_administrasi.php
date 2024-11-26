<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class doc_administrasi extends Model
{
    use HasFactory;

    protected $table = 'doc_administrasi';
    protected $guarded = ['id'];

    public function harmonisasi(): HasOne
    {
        return $this->hasOne(harmonisasi::class);
    }
}
