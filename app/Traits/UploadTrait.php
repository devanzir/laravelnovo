<?php
namespace App\Traits;

use App\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Exception;

trait UploadTrait
{
    private function imageUpload($images, $imagesColumn=null)
    {
       # $images = $request->file('photos');

        $uploadedImages = [];

        if(is_array($imagesColumn)){
            foreach($images as $image){
                
            $uploadedImages[] = [$imageColumn = $image->store('products', 'public')];    
                
            }
        } else{
            $uploadedImages = $images->store('logo', 'public');
        }

       
        return $uploadedImages;
    }      
}

