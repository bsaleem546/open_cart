<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute_Product;
use App\Models\Attributes;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image_Product;
use App\Models\Options;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    public function getAttributes()
    {
        return Attributes::with('_options')->get();
    }

    public function getBrands()
    {
        return Brand::all();
    }

    public function getCategories()
    {
        return Category::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('products')
            ->join('brands', 'brands.id','=', 'products.brand_id')
            ->join('categories', 'categories.id','=', 'products.category_id')
            ->select('products.*', 'categories.name as category', 'brands.name as brand')
            ->orderBy('created_at','ASC')->get();
        return view('admin.products.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $quantity = $request->p_quantity == null ? 0 :  $request->p_quantity;
            $price = $request->p_price == null ? 0 :  $request->p_price;

            $product = Product::create([
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'name' => $request->name,
                'short_description' => $request->short_desc,
                'long_description' => $request->long_desc,
                'quantity' => $quantity,
                'price' => $price,
                'in_stock' => $request->p_in_stock,
                'has_attributes' => $request->has_attributes
            ]);

            if ($request->has_attributes == 1){
                foreach ($request->all_attributes as $att){
                    Attribute_Product::create([
                        'product_id' => $product->id,
                        'attribute_id' => $att['at_id'],
                        'option_id' => $att['op_id'],
                        'quantity' => $att['quantity'],
                        'price' => $att['price'],
                        'in_stock' => $att['in_stock'],
                    ]);
                }
            }

            if ( count($request->img) > 0 ){
                $count = 1;
                foreach ($request->img as $image){
                    $img = rand(0, 99999).time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                    \Image::make($image)->save(public_path('uploads/').$img);
                    Image_Product::create([
                        'product_id' => $product->id,
                        'paths' => $img,
                        'is_main' => $count == 1 ? 1 : 0
                    ]);

                    $count = $count * 2;
                }
            }

            return Response::json(['status' => true, 'message' => 'Product created',
                'redirect' => route('products.index')]);
        }
        catch (\Exception $e){
//            dd($e);
            return Response::json(['status' => false, 'message' => 'Product not created', 'detail', $e]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        $images = Image_Product::where('product_id', $product->id)->get();
        $att = '';
        if ($product->has_attributes == 1){
            $att = Attribute_Product::join('attributes', 'attributes.id','=','attribute_product.attribute_id')
                ->join('options', 'options.id', '=', 'attribute_product.option_id')
                ->select('attribute_product.*', 'attributes.name as at_name', 'options.name as op_name')
                ->where('product_id', $product->id)->get();
        }

        return view('admin.products.edit', compact('product', 'images', 'att'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        try {

            $quantity = $request->p_quantity == null ? 0 :  $request->p_quantity;
            $price = $request->p_price == null ? 0 :  $request->p_price;

            $product = Product::where('id', $id)->update([
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'name' => $request->name,
                'short_description' => $request->short_desc,
                'long_description' => $request->long_desc,
                'quantity' => $quantity,
                'price' => $price,
                'in_stock' => $request->p_in_stock,
                'has_attributes' => $request->has_attributes
            ]);

            $pre_att = Attribute_Product::where('product_id', $id)->get();

            if ($request->has_attributes == 1){
                if (!$pre_att->isEmpty()){
                    foreach ($pre_att as $p){
                        $p->delete();
                    }
                }
                foreach ($request->all_attributes as $att){
                    Attribute_Product::create([
                        'product_id' => $id,
                        'attribute_id' => $att['at_id'],
                        'option_id' => $att['op_id'],
                        'quantity' => $att['quantity'],
                        'price' => $att['price'],
                        'in_stock' => $att['in_stock'],
                    ]);
                }
            }
            else{
                if (!$pre_att->isEmpty()){
                    foreach ($pre_att as $p){
                        $p->delete();
                    }
                }
            }

            $pre_img = Image_Product::where('product_id', $id)->get();
            if (!$pre_img->isEmpty()){
                foreach ($pre_img as $imgs){
                    foreach ($request->old_images as $i){
                        if ($i['image_id'] != $imgs->id){
                            $imgs->delete();
                        }
                    }
                }
            }

            if ( count($request->img) > 0 ){
                foreach ($request->img as $image){
                    $img = rand(0, 99999).time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                    \Image::make($image)->save(public_path('uploads/').$img);
                    Image_Product::create([
                        'product_id' => $id,
                        'paths' => $img,
                        'is_main' => 0
                    ]);
                }
            }

            return Response::json(['status' => true, 'message' => 'Product updated',
                'redirect' => route('products.index')]);
        }
        catch (\Exception $e){
            dd($e);
            return Response::json(['status' => false, 'message' => 'Product not created', 'detail', $e]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $att = Attribute_Product::where('product_id',$id)->get();
            if (!$att->isEmpty()){
                foreach ($att as $a){
                    $a->delete();
                }
            }
            $img = Image_Product::where('product_id',$id)->get();
            if (!$img->isEmpty()){
                foreach ($img as $i){
                    $i->delete();
                }
            }
            $product = Product::findOrFail($id);
            $product->delete();

            return Response::json(['status' => true, 'message' => 'Product deleted',
                'redirect' => route('products.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Product not deleted', 'detail', $e]);
        }
    }
}
