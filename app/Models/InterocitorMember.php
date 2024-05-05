<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterocitorMember extends Model
{
    use HasFactory;

    protected $connection = 'interocitorDB';
    
    protected $table = 'members';

    public function devices()
    {
        return $this->hasMany(InterocitorMemberDevices::class,'member_id','member_id');
    }
}
