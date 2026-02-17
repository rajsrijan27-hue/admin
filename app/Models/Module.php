<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
    'module_label',
    'module_display_name',
    'parent_module',
    'priority',
    'icon',
    'file_url',
    'page_name',
    'type',
    'access_for'
];

}
