<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

    public function category () {
        return $this->belongsto(Category::class);
    }

    public function subCategory () {
        return $this->belongsto(SubCategory::class);
    }
}
 