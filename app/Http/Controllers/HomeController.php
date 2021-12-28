<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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

        if (Auth::check()){
            $cart = Cart::where('user_id', Auth::user()->id)->get();
            $product = Product::find($id);
            if ($cart->isEmpty()){
                Cart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $id,
                    'product_name' => $product->name,
                    'product_slug' => $product->slug,
                    'quantity' => $qty,
                    'price' => ($price * $qty),
                    'att' => $att,
                    'p' => $price,
                    'category_id' => $product->category->id,
                ]);
                return Response::json(['status' => true, 'msg' => 'Product added to cart']);
            }
            else{
                foreach ($cart as $c){
                    if ($c->product_id == $id){
                        if ($att == $c->att){
                            $oldQty = $c["quantity"];
                            $newQty = $oldQty + $qty;
                            $oldPrice = $c["price"];
                            $newPrice = $oldPrice * $newQty;
                            $c["quantity"] = $newQty;
                            $c["price"] = $newPrice;
                            $c["p"] = $price;
                            $c->update();
                            return Response::json(['status' => true, 'msg' => 'Product added to cart']);
                        }
                    }
                }
                Cart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $id,
                    'product_name' => $product->name,
                    'product_slug' => $product->slug,
                    'quantity' => $qty,
                    'price' => ($price * $qty),
                    'att' => $att,
                    'p' => $price,
                    'category_id' => $product->category->id,
                ]);
                return Response::json(['status' => true, 'msg' => 'Product added to cart']);
            }
        }
        else{
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
        $cart = null;
        if (Auth::check()){
            $cart = Cart::where('user_id', Auth::user()->id)->get();
        }
        else{
            $cart = Session::get('cart');
        }
        return view('cart', compact('cart'));
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
        if (Auth::check()){
            $cart = Cart::find($id);
            $cart->delete();
            return Response::json(['status' => 1, 'msg' => 'Item remove']);
        }
        else{
            $cart = Session::get('cart');
            unset($cart[$id]);
            Session::put('cart', $cart);
            Session::save();
            return Response::json(['status' => 1, 'msg' => 'Item remove']);
        }
    }

    public function addCartSession($total, $discount, $ship, $finalTotal, $discountCode)
    {
        Session::put('checkoutSession', []);
        Session::save();

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
        $cart = null;
        $customer = null;
        $checkoutSession = Session::get('checkoutSession');
        if (Auth::check()){
            $cart = Cart::where('user_id', Auth::user()->id)->get();
            $customer = Customer::where('email', Auth::user()->email)->first();
            if ($cart->isEmpty()){
                return redirect()->back();
            }
        }else{
            $cart = Session::get('cart');
            if ($cart == null){
                return redirect()->back();
            }
        }
        return view('checkout', compact('cart', 'checkoutSession', 'customer'));
    }

    public function checkoutDetails()
    {
        $customer = null;
        $cart = null;
        $checkoutSession = Session::get('checkoutSession');

        if (Auth::check()){
            $cart = Cart::where('user_id', Auth::user()->id)->get();
            $customer = Customer::where('email', Auth::user()->email)->first();
        }
        else{
            $customer = Session::get('customer');
            $cart = Session::get('cart');
        }

        if ($cart == null || $customer == null){
            return redirect()->back();
        }

        return view('checkoutDetails', compact('customer', 'cart', 'checkoutSession'));
    }

    public function addCustomerDetails(Request $request)
    {
        if (Auth::check()){
            $customer = Customer::where('email', Auth::user()->email)->first();
            if ($customer){
                $customer->fname = $request->fname;
                $customer->lname = $request->lname;
                $customer->address = $request->address;
                $customer->city = $request->city;
                $customer->country = $request->country;
                $customer->phone = $request->phone;
                $customer->notes = $request->notes;
                $customer->update();
                return redirect('checkout-details');
            }else{
                Customer::create([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'address' => $request->address,
                    'city' => $request->city,
                    'country' => $request->country,
                    'email' => Auth::user()->email,
                    'phone' => $request->phone,
                    'notes' => $request->notes
                ]);
                return redirect('checkout-details');
            }

        }
        else{
            if ( $request->sign_up_shk == 'on' ){
                $user = User::where('email', $request->email)->first();
                if ($user == null) {
                   $user = User::create([
                        'name' => $request->fname . ' ' . $request->lname,
                        'email' => $request->email,
                        'password' => bcrypt($request->password)
                    ]);
                }
                $customer = Customer::where('email', $request->email)->first();
                if ($customer){
                    $customer->fname = $request->fname;
                    $customer->lname = $request->lname;
                    $customer->address = $request->address;
                    $customer->city = $request->city;
                    $customer->country = $request->country;
                    $customer->phone = $request->phone;
                    $customer->notes = $request->notes;
                    $customer->update();
                }else{
                    Customer::create([
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'address' => $request->address,
                        'city' => $request->city,
                        'country' => $request->country,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'notes' => $request->notes
                    ]);
                }
                $cart = Session::get('cart');
                if ($cart !== null){
                    foreach ($cart as $key => $value){
                        $dbCart = Cart::where('user_id', $user->id)->where('product_id', $value['id'])->where('att', $value['att'])->first();
                        if ($dbCart){
                            $dbCart->delete();
                        }
                        Cart::create([
                            'user_id' => $user->id,
                            'product_id' => $value['id'],
                            'product_name' => $value['name'],
                            'product_slug' => $value['slug'],
                            'quantity' => $value['quantity'],
                            'price' => $value['price'],
                            'att' => $value['att'],
                            'p' => $value['p'],
                            'category_id' => $value['category'],
                        ]);
                    }
                }
                if (Auth::attempt( ['email' => $request->email, 'password' => $request->password] )){
                    return redirect('checkout-details');
                }else{
                    return redirect()->back()->withErrors('Something went wrong');
                }
            }
            else{
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
        }
    }

    public function confirmOrder(Request $request)
    {
        if (Auth::check()){
            $customer = Customer::where('email', Auth::user()->email)->first();
            $cart = Cart::where('user_id', Auth::user()->id)->get();
            if ($customer == null || $cart->isEmpty()){
                return redirect('cart');
            }

            $order = new Order();
            $order->customer_id = $customer['id'];
            $order->sub_total = $request['total'];
            $order->discount = $request['discount'];
            $order->discount_code = $request['discountCode'];
            $order->shipping = $request['ship'];
            $order->total = $request['finalTotal'];
            $order->note = $customer['notes'];
            $order->status = 'PENDING';
            $order->save();

            foreach ($cart as $key => $value){
                $oProduct = new OrderProduct();
                $oProduct->product_id = $value['product_id'];
                $oProduct->order_id = $order['id'];
                $oProduct->quantity = $value['quantity'];
                $oProduct->total = $value['price'];
                $oProduct->attr = $value['att'];
                $oProduct->save();
            }

            Cart::where('user_id', Auth::user()->id)->delete();

            return view('orderCompleted')->with('orderID', $order['id']);
        }
        else {
            $customer = Session::get('customer');
            $cart = Session::get('cart');

            if ($customer == null || $cart == null){
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

            $order = new Order();
            $order->customer_id = $customer_id;
            $order->sub_total = $request['total'];
            $order->discount = $request['discount'];
            $order->discount_code = $request['discountCode'];
            $order->shipping = $request['ship'];
            $order->total = $request['finalTotal'];
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
            return view('orderCompleted')->with('orderID', $order['id']);
        }
    }

    public function orderTracking()
    {
        return view('orderTracking');
    }

    public function orderTrackingGet(Request $request)
    {
        $order = Order::find($request->id);
        $orderProduct = null;
        $customer = null;
        if ($order){
            $orderProduct = $order->orderProducts;
            $customer = $order->customer;
        }
        return redirect('order-tracking')->with('order', $order)->with('orderProduct' , $orderProduct)->with('customer' , $customer);
    }

}
