<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManagePages extends Model
{
    use HasFactory;
    use SoftDeletes; 
    protected $table = 'manage_pages';
    protected $fillable = [
        'title',
        'slug',
        'plateform_name',
        'plateform_file',
        'plateform_status',
        'disclaimers',
    ];
}
