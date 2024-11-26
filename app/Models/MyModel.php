<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\database\Eloquent\Builder;

class MyModel extends Model
{
    protected static function boot() {
        parent::boot();
        static::addGlobalScope('tahun', function(Builder $builder) {
            if (static::hasColumn('tanggal')) {
                $builder->whereYear('tanggal', app('selectedYear'));
            }
        });
    }
    
    protected static function hasColumn($column) 
    {
        return \Schema::hasColumn((new static)->getTable(), $column);
    }
}