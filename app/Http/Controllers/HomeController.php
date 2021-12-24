<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Image_Product;
use App\Models\Options;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\VariationValues;
use Carbon\Carbon;
use Carbon\Traits\Date;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                "category" => $product->category->id,
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
            "category" => $product->category->id,
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

    public function checkCoupon($coupon){
        $cart = Session::get('cart');
        $COUPON = Coupon::where('code', $coupon)->first();
        if ($COUPON == null){
            return Response::json(['status' => 0, 'msg' => 'No coupon found']);
        }
        else{
            $current_date = Carbon::now();//->format('Y-m-d')
            $endDateDB = date('Y-m-d',  strtotime($COUPON->end_date) );
            $resultDate = $current_date->lte($endDateDB);
            if ($resultDate == false){
                return Response::json(['status' => 1, 'msg' => 'Coupon has expired']);
            }
            if ($COUPON->quantity == 0){
                return Response::json(['status' => 2, 'msg' => 'Coupon limit is reached to zero']);
            }
            if ($COUPON->type == 'All'){
                return Response::json(['status' => 3, 'amount' => $COUPON->value,
                    'value_type' => $COUPON->value_type, 'msg' => 'Discounted price added to your total' ]);
            }
            if ($COUPON->type == 'Category'){
                $chk = false;
                foreach ($cart as $k => $v){
                    if($v['category'] == $COUPON->type_id){
                        $chk = true;
                    }
                }
                if ($chk == false){
                    return Response::json(['status' => 1, 'msg' => 'No coupon found']);
                }
                else{
                    return Response::json(['status' => 3, 'amount' => $COUPON->value,
                        'value_type' => $COUPON->value_type, 'msg' => 'Discounted price added to your total' ]);
                }
            }
            if ($COUPON->type == 'Product'){
                $chk = false;
                foreach ($cart as $k => $v){
                    if($v['id'] == $COUPON->type_id){
                        $chk = true;
                    }
                }
                if ($chk == false){
                    return Response::json(['status' => 1, 'msg' => 'No coupon found']);
                }
                else{
                    return Response::json(['status' => 3, 'amount' => $COUPON->value,
                        'value_type' => $COUPON->value_type, 'msg' => 'Discounted price added to your total' ]);
                }
            }
        }
        return 0;
    }

    public function removeItem($id)
    {
        $cart = Session::get('cart');
        unset($cart[$id]);
        Session::put('cart', $cart);
        Session::save();
        return Response::json(['status' => 1, 'msg' => 'Item remove']);
    }

    public function addCartSession($total, $discount, $ship, $finalTotal, $discountCode)
    {
        Session::put('checkoutSession',[
            'total' => $total,
            'discount' => $discount,
            'ship' => $ship,
            'finalTotal' => $finalTotal,
            'discountCode' => $discountCode,
        ]);
        Session::save();
    }

    public function checkout()
    {
        $cart = Session::get('cart');
        $checkoutSession = Session::get('checkoutSession');
        if ($cart == null){
            return redirect()->back();
        }
        if (Auth::check()){
            return redirect('checkout-details');
        }
        return view('checkout', compact('cart', 'checkoutSession'));
    }

    public function checkoutDetails()
    {
        $customer = '';
        if (Auth::check()){
            $customer = Customer::where('email', Auth::user()->email)->first();
            if ($customer == null){
                $customer = Session::get('customer');
            }
        }else{
            $customer = Session::get('customer');
        }

        if ($customer == '' || $customer == null){
            return redirect()->back();
        }

        $cart = Session::get('cart');
        $checkoutSession = Session::get('checkoutSession');
        return view('checkoutDetails', compact('customer', 'cart', 'checkoutSession'));
    }

    public function addCustomerDetails(Request $request)
    {
        if ($request->sign_up_shk == "on"){

            $user = User::where('email', $request->email)->first();

            if ($user){
                return redirect()->back()->withErrors(['msg' => 'You have already sign up. please sign in to move forward.']);
            }
            else{
                $newUser = User::create([
                    'name' => $request->fname,
                    'email' => $request->email,
                    'password' => bcrypt($request->password)
                ]);

                if ( Auth::attempt(['email' => $request->email, 'password' => $request->password ] ) ) {

                    Session::put('customer', [
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'address' => $request->address,
                        'city' => $request->city,
                        'country' => $request->country,
                        'email' => $request->email,
                        'password' => $request->password,
                        'sign_up_shk' => $request->sign_up_shk,
                        'phone' => $request->phone,
                        'notes' => $request->notes,
                    ]);
                    Session::save();
                    return redirect('checkout-details');
                }else{
                    return redirect()->back()->withErrors(['msg' => 'Error occured during login']);
                }
            }
        }
        Session::put('customer', [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'email' => $request->email,
            'password' => $request->password,
            'sign_up_shk' => $request->sign_up_shk,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);
        Session::save();
        return redirect( 'checkout-details');
    }

    public function confirmOrder(Request $request)
    {
        $customer = Session::get('customer');
        $cart = Session::get('cart');
        $checkoutSession = Session::get('checkoutSession');

        if ($customer == null || $cart == null || $checkoutSession == null){
            return redirect('cart');
        }

        $savedCustomer = Customer::where('email', $customer['email'])->first();
        $customer_id = '';
        if ($savedCustomer){
            $savedCustomer->fname = $customer['fname'];
            $savedCustomer->lname = $customer['lname'];
            $savedCustomer->address = $customer['address'];
            $savedCustomer->city = $customer['city'];
            $savedCustomer->country = $customer['country'];
            $savedCustomer->phone = $customer['phone'];
            $savedCustomer->notes = $customer['notes'];
            $savedCustomer->update();
            $customer_id = $savedCustomer->id;
        }
        else{
            $newCustomer = new Customer();
            $newCustomer->email = $customer['email'];
            $newCustomer->fname = $customer['fname'];
            $newCustomer->lname = $customer['lname'];
            $newCustomer->address = $customer['address'];
            $newCustomer->city = $customer['city'];
            $newCustomer->country = $customer['country'];
            $newCustomer->phone = $customer['phone'];
            $newCustomer->notes = $customer['notes'];
            $newCustomer->save();
            $customer_id = $newCustomer->id;
        }

        if ( $customer['sign_up_shk'] == "on" ){
            $user = User::where('email', $request->email)->first();
            if(!$user){
                $newUser = User::create([
                    'name' => $customer['fname'],
                    'email' => $customer['email'],
                    'password' => bcrypt($customer['password'])
                ]);
                Auth::attempt(['email' => $request->email, 'password' => $request->password ]);
            }
        }

        $order = new Order();
        $order->customer_id = $customer_id;
        $order->sub_total = $checkoutSession['total'];
        $order->discount = $checkoutSession['discount'];
        $order->discount_code = $checkoutSession['discountCode'];
        $order->shipping = $checkoutSession['ship'];
        $order->total = $checkoutSession['finalTotal'];
        $order->note = $customer['notes'];
        $order->status = 'PENDING';
        $order->save();

        foreach ($cart as $key => $value){
            $oProduct = new OrderProduct();
            $oProduct->product_id = $value['id'];
            $oProduct->order_id = $order['id'];
            $oProduct->quantity = $value['quantity'];
            $oProduct->total = $value['price'];
            $oProduct->attr = $value['att'];
            $oProduct->save();
        }

        Session::put('customer', []);
        Session::put('cart', []);
        Session::put('checkoutSession', []);
        Session::save();
        return view('orderCompleted')->with('orderID', $order['id']);
    }

}
