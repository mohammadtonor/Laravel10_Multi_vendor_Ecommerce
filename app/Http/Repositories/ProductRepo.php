<?php

namespace App\Http\Repositories;

use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request ;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductImageGallery;
use Illuminate\Support\Str;
use Exception;

class ProductRepo
{
    use ImageUploadTrait;

    public function storeProduct(
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

        $product = new Product();
        $thumbPath = $this->uploadImage($image, 'image', 'uploads');

        $product->thumb_image =  $thumbPath;
        $product->name = $name;
        $product->slug = Str::slug($name);
        $product->vendor_id = Auth::user()->vendor->id;
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
        $product->seo_title = $seo_title;
        $product->seo_description = $seo_description;

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
        $product->vendor_id = $product->vendor_id;
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
        $product->is_approved = $product->is_approved;
        $product->seo_title = $seo_title;
        $product->seo_description = $seo_description;

        return  $product->save() ?
                ["status" => "success", "result" => $product] :
                ["status" => "failed"];
    }

    public function deleteProduct($id) {
        try {
            $product = Product::findOrFail($id);
            $this->deleteImage($product->thumb_image);

            ProductImageGallery::where('product_id', $product->id)->get()
                ->map(function ($image) {
                    $this->deleteImage($image->image);
                    $image->delete();
                });

            ProductVariant::where('product_id', $product->id)->get()
                ->map(function ($variant) {
                    $variant->productVariantItems()->delete();
                    $variant->delete();
                });

            $product->delete();
            return ['status' =>'success'];
        } catch (Exception  $error) {
            return ["status" => "failed" ];
        }
    }

    public function changeProductStatus ($id, $isChecked) {
        try {
            $productVariant = Product::findOrFail($id);
            $productVariant->status = $isChecked == 'true' ? 1 : 0;
            $productVariant->save();
            return ["status" => "success"];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }
    }

    public function storeImageGallery ($images, $product_id) {
        try {
            $imagePaths = $this->uploadMultipleImage($images, 'image', 'uploads');
            foreach($imagePaths as $image) {
                $productImageGallery = new ProductImageGallery();
                $productImageGallery->image = $image;
                $productImageGallery->product_id = $product_id;
                $productImageGallery->save();
            }
            return ["status" => "success", "result" => $productImageGallery];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }
    }

    public function deleteImageGallery ($id) {
        try {
            $productImageGallery = ProductImageGallery::findOrFail($id);
            if($productImageGallery->product->vendor_id !== Auth::user()->vendor->id) {
                return abort(403);
            }
            $this->deleteImage($productImageGallery->image);
            $productImageGallery->delete();
            return ["status" => "success"];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }
    }

    public function storeProductVariant ($name, $productId, $status) {

        try {
            $productVariant = new ProductVariant();
            $productVariant->product_id = $productId;
            $productVariant->name = $name;
            $productVariant->status = $status;
            $productVariant->save();

            return ["status" => "success", "result" => $productVariant];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }

    }

    public function updateProductVariant ($id, $name, $productId, $status) {

        try {
            $productVariant = ProductVariant::findOrFail($id);
            $productVariant->product_id = $productId;
            $productVariant->name = $name;
            $productVariant->status = $status;
            $productVariant->save();

            return ["status" => "success", "result" => $productVariant];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }

    }

    public function deleteProductVariant ($id) {
        try {
            $productVariant = ProductVariant::findOrFail($id);
            $productVariant->delete();
            return ["status" => "success"];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }
    }

    public function changeProductVariantstatus ($id, $isChecked) {
        try {
            $productVariant = ProductVariant::findOrFail($id);
            $productVariant->status = $isChecked == 'true' ? 1 : 0;
            $productVariant->save();
            return ["status" => "success"];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }
    }


    public function storeProductVariantItem ($name, $variantId, $price, $isDefault, $status) {

        try {
            $productVariantItem = new ProductVariantItem();
            $productVariantItem->product_variant_id = $variantId;
            $productVariantItem->name = $name;
            $productVariantItem->price = $price;
            $productVariantItem->is_default = $isDefault;
            $productVariantItem->status = $status;
            $productVariantItem->save();

            return ["status" => "success", "result" => $productVariantItem];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }

    }

    public function updateProductVariantItem ($id , $name, $variantId, $price, $isDefault, $status) {

        try {
            $productVariantItem = ProductVariantItem::findOrFail($id);
            $productVariantItem->product_variant_id = $variantId;
            $productVariantItem->name = $name;
            $productVariantItem->price = $price;
            $productVariantItem->is_default = $isDefault;
            $productVariantItem->status = $status;
            $productVariantItem->save();

            return ["status" => "success", "result" => $productVariantItem];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }

    }

    public function deleteProductVariantItem ($id) {
        try {
            $productVariant = ProductVariantItem::findOrFail($id);
            $productVariant->delete();
            return ["status" => "success"];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }
    }

    public function changeProductVarianItemtStatus ($id, $isChecked) {
        try {
            $productVariant = ProductVariantItem::findOrFail($id);
            $productVariant->status = $isChecked == 'true' ? 1 : 0;
            $productVariant->save();
            return ["status" => "success"];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }
    }

    public function getProductVariant (int $id) {
        return ProductVariant::findOrFail( $id);
     }

    public function getSubCategories (int $id) {
        return SubCategory::where('category_id', $id)->get();
     }

     public function getChildCategories (int $id) {
        return ChildCategory::where('sub_category_id', $id)->get();
     }
}
