<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            $sale_price = $request->p_sale_price == null ? 0 :  $request->p_sale_price;

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));

            $product = Product::create([
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'name' => $request->name,
                'slug' => $slug,
                'short_description' => $request->short_desc,
                'long_description' => $request->long_desc,
                'quantity' => $quantity,
                'price' => $price,
                'sale_price' => $sale_price,
                'in_stock' => $request->p_in_stock,
                'is_featured' => false,
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

                    $combo = '';
                    for ($k = 0; $k < count($request->v_options[$j]['options']); $k++ ){
                        $combo .= '|'.$request->v_options[$j]['options'][$k];
                    }
                    $v = Variation::create([
                            'product_id' => $product->id,
                            'option_name' => $combo,
                            'combo_id' => $j + 1
                        ]);

                    $v_sale_price = $request->v_options[$j]['sale_price'] == null ? 0 : $request->v_options[$j]['sale_price'];
                    VariationValues::create([
                        'product_id' => $product->id,
                        'combo_id' => $v->id,//$j + 1,
                        'quantity' => $request->v_options[$j]['quantity'],
                        'price' => $request->v_options[$j]['price'],
                        'sale_price' => $v_sale_price,
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

        $att = null;
        $options = null;
        $variations = null;
        $variation_values = null;
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
            $sale_price = $request->p_sale_price == null ? 0 :  $request->p_sale_price;

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));

            Product::where('id', $id)->update([
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'name' => $request->name,
                'slug' => $slug,
                'short_description' => $request->short_desc,
                'long_description' => $request->long_desc,
                'quantity' => $quantity,
                'price' => $price,
                'sale_price' => $sale_price,
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

                    $combo = '';
                    for ($k = 0; $k < count($request->v_options[$j]['options']); $k++ ){
                        $combo .= '|'.$request->v_options[$j]['options'][$k];
                    }
                    $v = Variation::create([
                        'product_id' => $id,
                        'option_name' => $combo,
                        'combo_id' => $j + 1
                    ]);

                    $v_sale_price = $request->v_options[$j]['sale_price'] == null ? 0 : $request->v_options[$j]['sale_price'];
                    VariationValues::create([
                        'product_id' => $id,
                        'combo_id' => $v->id,//$j + 1,
                        'quantity' => $request->v_options[$j]['quantity'],
                        'price' => $request->v_options[$j]['price'],
                        'sale_price' => $v_sale_price,
                        'in_stock' => $request->v_options[$j]['in_stock'],
                    ]);
                }
            }

            foreach ($request->old_images as $i){
                $pre_img = Image_Product::where('id', $i['image_id'])->first();
                if ($pre_img && $i['status'] == false){
                    $pre_img->delete();
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

    public function featured(Request $request)
    {
        try {

            $featured = $request->chk == true ? 1 : 0;

            $f = Product::find($request->id);
            $f->is_featured = $featured;
            $f->update();
            return Response::json(['status' => true, 'message' => 'Product featured',
                'redirect' => route('products.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Product not featured', 'detail', $e]);
        }
    }
}
