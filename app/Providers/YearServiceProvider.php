<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\tahun;

class YearServiceProvider extends ServiceProvider
{
    public function register() 
    {
        
       
    }
    
    public function boot() {
        $select = tahun::select('no')->where('selected', 1)->First();
        if ($select) {
            $tahun = $select->no;
        }else{
            $tahun = date('Y');
        }
         $this->app->singleton('selectedYear', function() use($tahun)  {
            return $tahun;
        });
    }
}