<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Image_Product;
use App\Models\Options;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\VariationValues;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function getCategoryBySlug($slug)
    {
        $category = Category::where('categories.slug','=',$slug)->first();
        $products = Product::where('category_id', $category->id)->paginate(12);

        return view('CategoryBySlug', compact('products', 'category'));
    }

    public function allCategories()
    {
        $categories = Category::latest()->paginate(12);
        return view('Categories', compact('categories'));
    }

    public function allProducts()
    {
        $products = Product::latest()->paginate(12);
        return view('Products', compact('products'));
    }

    public function getProductBySlug($slug)
    {
//        dd( Session::get('cart') );
        $product = Product::where('slug', $slug)->first();
        return view('ProductBySlug', compact('product'));
    }

    public function addToCart(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        $price = $request->price;
        $att = $request->att == null ? '' : $request->att;

        Session::start();
        $product = Product::find($id);
        $cart = Session::has('cart') ? Session::get('cart') : null;

        if ($cart == null){
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "slug" => $product->slug,
                "quantity" => $qty,
                "price" =>  ($price * $qty),//$product->sale_price > 0 ? ($product->sale_price * $qty) : ($product->price * $qty),
                "att" => $att,
                "p" => $price,
            ];
            Session::put('cart', $cart);
            Session::save();
            return Response::json(['status' => true, 'msg' => 'Product added to cart']);
        }

        if(isset($cart[$id])) {
            if ($att == $cart[$id]["att"]){
                $oldQty = $cart[$id]["quantity"];
                $newQty = $oldQty + $qty;
                $oldPrice = $cart[$id]["price"];
                $newPrice = $oldPrice * $newQty;
                $cart[$id]["quantity"] = $newQty;
                $cart[$id]["price"] = $newPrice;
                $cart[$id]["p"] = $price;
                Session::put('cart', $cart);
                Session::save();
                return Response::json(['status' => true, 'msg' => 'Product added to cart']);
            }
        }

        $cart[$id] = [
            "id" => $product->id,
            "name" => $product->name,
            "slug" => $product->slug,
            "quantity" => $qty,
            "price" => ($price * $qty),//$product->sale_price > 0 ? ($product->sale_price * $qty) : ($product->price * $qty),
            "att" => $att,
            "p" => $price,
        ];
        Session::put('cart', $cart);
        Session::save();
        return Response::json(['status' => true, 'msg' => 'Product added to cart']);
    }

    public function addToWishlist($id)
    {
        $product = Product::find($id);

        $wishlist = Session::get('wishlist');
        if ($wishlist == null){
            $wishlist[$id] = [
                'product_id' => $id,
                'name' => $product->name,
                'price' => $product->price,
                'slug' => $product->slug
            ];
            Session::put('wishlist', $wishlist);
            Session::save();
            return Response::json(['status' => true, 'msg' => 'Product added to wishlist']);
        }

        if ( isset($wishlist[$id]) ){
            unset($wishlist[$id]);
            Session::put('wishlist', $wishlist);
            Session::save();
            return Response::json(['status' => true, 'msg' => 'Product removed from wishlist']);
        }

        $wishlist[$id] = [
            'product_id' => $id,
            'name' => $product->name,
            'price' => $product->price,
            'slug' => $product->slug
        ];
        Session::put('wishlist', $wishlist);
        Session::save();
        return Response::json(['status' => true, 'msg' => 'Product added to wishlist']);
    }

    public function viewCart()
    {
        $shipping = Shipping::all();
        return view('cart', compact('shipping'));
    }

    public function checkCoupon($coupon)
    {
        $COUPON = Coupon::where('code', $coupon)->first();
        if ($COUPON == null){
            return Response::json(['status' => 0, 'msg' => 'No code found']);
        }
        else{
            $current_date = Carbon::now();//->format('Y-m-d')
            $endDateDB = date('Y-m-d',  strtotime($COUPON->end_date) );
            $resultDate = $current_date->lte($endDateDB);
            dd($resultDate);
        }
    }
}
