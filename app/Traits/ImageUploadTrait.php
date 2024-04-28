<?php

namespace  App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait ImageUploadTrait {
    public function uploadImage($request, $inputImage, $path) {
        if (!empty($request)) {
            $image = $request;
            $ext = $image->getClientOriginalExtension();
            $imageName = 'image_'.uniqid().'.'.$ext;
            $image->move(public_path($path), $imageName);

            return $path.'/'.$imageName;
        }
    }

    public function uploadMultipleImage($images, $inputImage, $path) {
        $imagePaths = [];
        if (count($images) > 0) {
            foreach($images as $image){
                $ext = $image->getClientOriginalExtension();
                $imageName = 'image_'.uniqid().'.'.$ext;

                $image->move(public_path($path), $imageName);

                $imagePaths[] = $path.'/'.$imageName;
            }

            return $imagePaths;
        }
    }

    public function updateImage($request, $inputImage, $path, $oldPath) {
        if (!empty($request)) {
            if(File::exists(public_path($oldPath))){
                File::delete(public_path($oldPath));
            }

            $image = $request;
            $ext = $image->getClientOriginalExtension();
            $imageName = 'image_'.uniqid().'.'.$ext;

            $image->move(public_path($path), $imageName);

            return $path.'/'.$imageName;
        }
    }

    public function deleteImage(string $path) {
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }
}
