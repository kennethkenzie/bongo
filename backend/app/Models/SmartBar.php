<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmartBar extends Model
{
    protected $fillable = ['message', 'cta_text', 'style'];
}
