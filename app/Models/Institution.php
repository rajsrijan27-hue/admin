<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
   protected $fillable = [
    'name',
    'code',
    'email',
    'contact_number',
    'address',
    'institution_url',
    'default_language',
    'login_template',
    'logo',
    'admin_name',
    'admin_email',
    'admin_mobile',
    'invoice_type',
    'invoice_amount',
    'payment_mode',
    'payment_status',
    'status'
];


}
