<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArtistFeatureds extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'artist_featureds';
    protected $fillable = [
        'artist_id',
        'title',
        'video_url',
        'description',
        'status',
        'is_preview',
    ];
}
