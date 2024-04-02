<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artists extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'artists';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'profile_image'
    ];
}
