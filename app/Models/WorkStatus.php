<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WorkStatus extends Model
{
    use SoftDeletes;

    protected $table = 'work_status_master';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
    'id',
    'work_status_code',   // NEW
    'work_status_name',
    'description',        // NEW
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
