<?php

namespace App\Models;

use App\Models\User;
use App\Models\tahun;
use App\Models\rancangan;
use App\Models\kpengajuan;
use App\Models\pemrakarsa;
use App\Models\pdraf;
use App\Models\padministrasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class harmonisasi extends MyModel
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'harmonisasi';

    protected $with = ['kpengajuan', 'padministrasi', 'pemrakarsa', 'pdraf', 'rancangan', 'tahun', 'doc_administrasi', 'doc_penyampaian', 'doc_rapat', 'user', 'surat_dprd', 'surat_pemda', 'surat_rperkada'];

    public function kpengajuan()
    {
        return $this->belongsTo(kpengajuan::class);
    }

    public function padministrasi()
    {
        return $this->belongsTo(padministrasi::class);
    }

    public function pemrakarsa()
    {
        return $this->belongsTo(pemrakarsa::class);
    }

    
    public function pdraf()
    {
        return $this->belongsTo(pdraf::class);
    }

    public function rancangan()
    {
        return $this->belongsTo(rancangan::class);
    }

    public function tahun()
    {
        return $this->belongsTo(tahun::class);
    }

    public function doc_administrasi()
    {
        return $this->belongsTo(doc_administrasi::class);
    }

    public function doc_penyampaian()
    {
        return $this->belongsTo(doc_penyampaian::class);
    }

    public function doc_rapat()
    {
        return $this->belongsTo(doc_rapat::class);
    }

    public function surat_dprd()
    {
        return $this->belongsTo(surat_dprd::class);
    }

    public function surat_pemda()
    {
        return $this->belongsTo(surat_pemda::class);
    }

    public function surat_rperkada()
    {
        return $this->belongsTo(surat_rperkada::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
