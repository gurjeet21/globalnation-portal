<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pages';
    protected $fillable = [
        'page_title',
        'page_slug',
        'description',
        'background_image',
        'status',
        'is_preview',
        'is_dynamic',
    ];
}
