<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.shippings.index')->with('data', Shipping::with('products')->get() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shippings.create')->with('products', Product::all() );
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
            $data = $request->validate([
                'city' => ['required', 'string','unique:shippings', 'max:255'],
                'rate' => ['required', 'numeric', 'between:1,9999999.99']
            ]);

            $shipping = Shipping::create($data);
            $shipping->products()->sync($request->products, false);

            return Response::json(['status' => true, 'message' => 'Shipping created',
                'redirect' => route('shippings.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Shipping not created', 'detail', $e]);
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
        $data = Shipping::with('products')->where('shippings.id',$id)->first();
        $products = Product::all();
        return view('admin.shippings.edit', compact('data', 'products') );
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
            $data = $request->validate([
                'city' => ['required', 'string', 'max:255'],
                'rate' => ['required', 'numeric', 'between:1,9999999.99']
            ]);

            $shipping = Shipping::findOrFail($id);
            $shipping->city = $request->city;
            $shipping->rate = $request->rate;
            $shipping->update();
            $shipping->products()->sync($request->products);

            return Response::json(['status' => true, 'message' => 'Shipping updated',
                'redirect' => route('shippings.index')]);
        }
        catch (\Exception $e){
            dd($e);
            return Response::json(['status' => false, 'message' => 'Shipping not updated', 'detail', $e]);
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

            DB::table('shipping_product')->where('shipping_id', $id)->delete();
            Shipping::where('id', $id)->delete();

            return Response::json(['status' => true, 'message' => 'Shipping deleted',
                'redirect' => route('shippings.index')]);
        }
        catch (\Exception $e){
            dd($e);
            return Response::json(['status' => false, 'message' => 'Shipping not deleted', 'detail', $e]);
        }
    }
}
