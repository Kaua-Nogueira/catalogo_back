<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'slug', 'domain', 'logo', 'tagline', 'whatsapp', 'pix_key',
        'instagram', 'facebook', 'address', 'email'
    ];
}
