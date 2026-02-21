<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(MasterItem::class, 'category_item', 'category_id', 'item_id');
    }
}
