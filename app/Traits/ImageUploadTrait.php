<?php

namespace  App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait ImageUploadTrait {
    public function uploadImage(Request $request, $inputImage, $path) {
        if ($request->hasFile($inputImage)) {

            $image = $request->{$inputImage};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'image_'.uniqid().'.'.$ext;
            $image->move(public_path($path), $imageName);

            return $path.'/'.$imageName;
        }
    }

    public function uploadMultipleImage(Request $request, $inputImage, $path) {
        $imagePaths = [];
        if ($request->hasFile($inputImage)) {

            $images = $request->{$inputImage};

            foreach($images as $image){
                $ext = $image->getClientOriginalExtension();
                $imageName = 'image_'.uniqid().'.'.$ext;
                
                $image->move(public_path($path), $imageName);

                $imagePaths[] = $path.'/'.$imageName;
            }

            return $imagePaths;
        }
    }

    public function updateImage(Request $request, $inputImage, $path, $oldPath) {
        if ($request->hasFile($inputImage)) {
            if(File::exists(public_path($oldPath))){
                File::delete(public_path($oldPath));
            }

            $image = $request->{$inputImage};
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
