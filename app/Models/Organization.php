<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name','type','registration_number','gst',
        'address','city','state','country','pincode',
        'contact_number','email','timezone',
        'organization_url','software_url','logo','language',
        'admin_name','admin_email','admin_mobile',
        'status','mou_copy','po_number','po_start_date','po_end_date',
        'plan_type','enabled_modules',
        'invoice_type','invoice_frequency','invoice_amount',
        'payment_status','payment_date','transaction_reference',
        'poc_name','poc_email','poc_contact','support_sla'
    ];
}
