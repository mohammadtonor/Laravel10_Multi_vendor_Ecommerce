<?php

namespace App\Http\Repositories;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductRepo
{
    use ImageUploadTrait;
    public function storeProduct(Request $request) {

        $product = new Product();
        $thumbPath = $this->uploadImage($request, 'image', 'uploads');

        $product->thumb_image =  $thumbPath;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->video_link = $request->video_link;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->sku= $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->is_approved = 0;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_descriptrion;

        return  $product->save() ?
                ["status" => "success", "result" => $product] :
                ["status" => "failed"];
    }

    public function updateProduct(
        $id,
        $image,
        $name,
        $category,
        $sub_category,
        $child_category,
        $brand,
        $qty,
        $video_link,
        $short_description,
        $long_description,
        $sku,
        $price,
        $offer_price,
        $offer_start_date,
        $offer_end_date,
        $product_type,
        $status,
        $seo_title,
        $seo_description,
    ) {

        $product = Product::findOrFail($id);
        $thumbPath =  $this->updateImage($image, 'image', 'uploads', $product->thumb_image);

        $product->thumb_image =  !empty($thumbPath) ?  $thumbPath  : $product->thumb_image;
        $product->name = $name;
        $product->slug = Str::slug($name);
        $product->vendor_id = $product->vendor->id;
        $product->category_id = $category;
        $product->sub_category_id = $sub_category;
        $product->child_category_id = $child_category;
        $product->brand_id = $brand;
        $product->qty = $qty;
        $product->video_link = $video_link;
        $product->short_description = $short_description;
        $product->long_description = $long_description;
        $product->sku= $sku;
        $product->price = $price;
        $product->offer_price = $offer_price;
        $product->offer_start_date = $offer_start_date;
        $product->offer_end_date = $offer_end_date;
        $product->product_type = $product_type;
        $product->status = $status;
        $product->is_approved = 0;
        $product->seo_title = $seo_title;
        $product->seo_description = $seo_description;

        return  $product->save() ?
                ["status" => "success", "result" => $product] :
                ["status" => "failed"];
    }

    public function getSubCategories (int $id) {
        return SubCategory::where('category_id', $id)->get();
     }

     public function getChildCategories (int $id) {
        return ChildCategory::where('sub_category_id', $id)->get();
     }
}
