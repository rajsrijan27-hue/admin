<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
// use App\Models\Staff;


class Religion extends Model
{
    use SoftDeletes;

    protected $table = 'religion_master';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'religion_name',
        'status',
        'display_order',
        'created_by',
        'updated_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    // public function staff()
    // {
    //     return $this->hasMany(Staff::class, 'religion_id');
    // }

}


