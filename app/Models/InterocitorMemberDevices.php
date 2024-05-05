<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterocitorMemberDevices extends Model
{
    use HasFactory;
    protected $connection = 'interocitorDB';
    
    protected $table = 'memberdevice';

    // Define the inverse of the one-to-many relationship with Member
    public function member()
    {
        return $this->belongsTo(InterocitorMember::class,'member_id','member_id');
    }
}
