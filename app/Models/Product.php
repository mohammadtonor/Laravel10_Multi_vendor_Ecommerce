<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function subCategory () {
        return $this->belongsTo(SubCategory::class);
    }

    public function childCategory () {
        return $this->belongsTo(ChildCategory::class);
    }

    public function vendor () {
        return $this->belongsTo(Vendor::class);
    }

    function productImageGallery() {
        return $this->hasMany(ProductImageGallery::class);
    }
}
