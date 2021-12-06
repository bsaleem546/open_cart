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
use App\Models\Variation;
use App\Models\VariationValues;
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
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.products.create', compact('brands', 'categories'));
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

            if ($request->has_attributes == 1){
                for ($i = 0; $i < count($request->varition); $i++){
                    $att = Attributes::create([
                        'product_id' => $product->id,
                        'name' => $request->varition[$i]['att']
                    ]);
                    foreach ($request->varition[$i]['option'] as $rv){
                        Options::create([
                            'product_id' => $product->id,
                            'attribute_id' => $att->id,
                            'name' => $rv
                        ]);
                    }
                }

                for ($j = 0; $j < count($request->v_options); $j++){

                    for ($k = 0; $k < count($request->v_options[$j]['options']); $k++ ){
                        Variation::create([
                            'product_id' => $product->id,
                            'option_name' => $request->v_options[$j]['options'][$k],
                            'combo_id' => $j + 1
                        ]);
                    }

                    VariationValues::create([
                        'product_id' => $product->id,
                        'combo_id' => $j + 1,
                        'quantity' => $request->v_options[$j]['quantity'],
                        'price' => $request->v_options[$j]['price'],
                        'in_stock' => $request->v_options[$j]['in_stock'],
                    ]);
                }
            }

            return Response::json(['status' => true, 'message' => 'Product created',
                'redirect' => route('products.index')]);
        }
        catch (\Exception $e){
            dd($e);
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
        $brands = Brand::all();
        $categories = Category::all();
        $images = Image_Product::where('product_id', $product->id)->get();

        $att = '';
        $options = '';
        $variations = '';
        $variation_values = '';
        if ($product->has_attributes == 1){

            $att = Attributes::where('product_id', $id)->get();
            $options = Options::where('product_id', $id)->get();

            $variations = Variation::where('product_id', $id)->get();
            $variation_values = VariationValues::where('product_id', $id)->get();

        }

        return view('admin.products.edit', compact('product', 'brands',
            'categories', 'images', 'att', 'options', 'variations', 'variation_values') );
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

            Product::where('id', $id)->update([
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

            Options::where('product_id', $id)->delete();
            Attributes::where('product_id', $id)->delete();
            Variation::where('product_id', $id)->delete();
            VariationValues::where('product_id', $id)->delete();

            if ($request->has_attributes == 1){
                for ($i = 0; $i < count($request->varition); $i++){
                    $att = Attributes::create([
                        'product_id' => $id,
                        'name' => $request->varition[$i]['att']
                    ]);
                    foreach ($request->varition[$i]['option'] as $rv){
                        Options::create([
                            'product_id' => $id,
                            'attribute_id' => $att->id,
                            'name' => $rv
                        ]);
                    }
                }

                for ($j = 0; $j < count($request->v_options); $j++){

                    for ($k = 0; $k < count($request->v_options[$j]['options']); $k++ ){
                        Variation::create([
                            'product_id' => $id,
                            'option_name' => $request->v_options[$j]['options'][$k],
                            'combo_id' => $j + 1
                        ]);
                    }

                    VariationValues::create([
                        'product_id' => $id,
                        'combo_id' => $j + 1,
                        'quantity' => $request->v_options[$j]['quantity'],
                        'price' => $request->v_options[$j]['price'],
                        'in_stock' => $request->v_options[$j]['in_stock'],
                    ]);
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
            Options::where('product_id', $id)->delete();
            Attributes::where('product_id', $id)->delete();
            Variation::where('product_id', $id)->delete();
            VariationValues::where('product_id', $id)->delete();
            Image_Product::where('product_id', $id)->delete();
            Product::where('id', $id)->delete();

            return Response::json(['status' => true, 'message' => 'Product deleted',
                'redirect' => route('products.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Product not deleted', 'detail', $e]);
        }
    }
}
