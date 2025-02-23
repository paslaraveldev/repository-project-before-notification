<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    protected $fillable = ['purpose', 'mission', 'vision', 'features', 'audience', 'workflow', 'policies', 'team', 'phone1', 'phone2', 'phone3', 'phone4', 'email', 
    'po_box'];
}
