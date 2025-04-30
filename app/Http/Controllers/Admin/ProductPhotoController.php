<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    public function removePhoto(Request $request)
    {
        $photoName = $request->get('photoName');
        
        if (Storage::disk('public')->exists($photoName)) {
            Storage::disk('public')->delete($photoName);
        }

        $removePhoto = ProductPhoto::where('image', $photoName);

        if ($removePhoto->exists()) {
            $productId = $removePhoto->first()->product_id;
            $removePhoto->delete();

            flash('Imagem Removida Com Sucesso!')->success();
            return redirect()->route('admin.products.edit', ['product' => $productId]);
        } else {
            flash('Foto não encontrada!')->error();
            return redirect()->back();
        }
    }
}

