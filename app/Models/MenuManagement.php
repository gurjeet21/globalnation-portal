<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuManagement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'parent_id', 'sort_order', 'menu_type'];

    public function parent()
    {
        return $this->belongsTo(MenuManagement::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuManagement::class, 'parent_id')->orderBy('sort_order');
    }
}
