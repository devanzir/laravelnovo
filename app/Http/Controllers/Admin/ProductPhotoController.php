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
        
        // Debug: Verificar valor de photoName
        #dd($photoName);
        
        // REMOVER OS ARQUIVOS
        if (Storage::disk('public')->exists($photoName)) {
            Storage::disk('public')->delete($photoName);
        }

        // REMOVER DO BANCO DE DADOS
        $removePhoto = ProductPhoto::where('image', $photoName);

        // Debug: Verificar se a consulta encontrou algum resultado
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

