<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JobType extends Model
{
    use SoftDeletes;

    protected $table = 'job_type_master';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
    'id',
    'job_type_code',     // NEW
    'job_type_name',
    'description',       // NEW
    'status',
    'display_order',
    'created_by',
    'updated_by'
];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
