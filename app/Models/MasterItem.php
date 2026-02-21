<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function categories()
    {
        return $this->belongsToMany(MasterCategory::class, 'category_item', 'item_id', 'category_id');
    }
}
