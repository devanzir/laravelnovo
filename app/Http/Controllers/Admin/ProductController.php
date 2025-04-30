<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Http\Requests\ProductsRequest;
use Illuminate\Support\Facades\App;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    use UploadTrait;

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userStore = auth()->user()->store;
        $products = $userStore->products()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories= \App\Category::all(['id', 'name']);

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
      # $images = $request->file('photos');

        $data = $request->all();
        $categories = $request->get('categories',null);

        $store = auth()->user()->store;
        $product = $store->products()->create($data);

        $product->categories()->sync($categories);

        if($request->hasFile('photos')){
            $images = $request->file('photos'); 
            $uploadedImages = $this->imageUpload($images, 'image');
            $product->photos()->createMany($uploadedImages);

        }else {
            $product->photos()->create(['image' => 'default_image.jpg']);
        }
        flash('Produto criado com sucesso')->success();
        return redirect()->route('admin.products.index');
   
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $product = $this->product->findOrFail($product);

        $categories= \App\Category::all(['id', 'name']);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $product)
    {
        $data= $request->all();
        $categories = $request->get('categories',null);

        $product = $this->product->find($product);
        $product->update($data);
        if(!is_null($categories))
        $product->categories()->sync($categories);

        if($request->hasFile('photos')){
            $images = $request->file('photos');
            $uploadedImages = $this->imageUpload($images, 'image');
            $product->photos()->createMany($uploadedImages);
       }

        flash('Produto Atualizado com sucesso')->success();
        return redirect()->route('admin.products.index');
    }

   /**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($product)
{
    $product = $this->product->find($product);

    if ($product) {
        DB::table('product_photos')->where('product_id', $product->id)->delete();

        DB::table('category_product')->where('product_id', $product->id)->delete();

        $product->delete();

        flash('Produto Deletado com sucesso')->success();
    } else {
        flash('Produto não encontrado')->error();
    }

    return redirect()->route('admin.products.index');
}


    private function imageUpload(array $images, $imageColumn = 'photos')
    {
        $uploadedImages = [];

        foreach($images as $image){
            if(!$image->isValid()) {
                throw new Exception('Invalid image');
            }

            $filename = uniqid() . '_' . $image->getClientOriginalName();
            $path = 'products/' . $filename;

            Storage::disk('public')->put($path, file_get_contents($image)); $uploadedImages[] = [$imageColumn => $path];

            $uploadedImages[] = [$imageColumn => $path];
        }
     
        return $uploadedImages;
    
    }
}

