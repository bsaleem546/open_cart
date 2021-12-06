<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Coupon::orderBy('created_at', 'ASC')->get();
        return view('admin.coupons.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
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
                'type' => ['required'],
                'over_all' => ['required'],
                'code' => ['required', 'string','unique:coupons', 'max:255'],
                'value' => ['required', 'numeric', 'between:0,999999.999999'],
                'value_type' => ['required'],
                'quantity' => ['required', 'integer'],
                'begin_date' => ['required', 'date'],
                'end_date' => ['required', 'date']
            ]);

            $type_id = 0;
            $over_all = 0;
            if ( $request->type == 'All' ){
                $type_id = 0;
                $over_all = 1;
            }
            elseif ( $request->type == 'Category' ){
                $type_id = $request->category_id;
            }
            elseif ( $request->type == 'Brand' ){
                $type_id = $request->brand_id;
            }
            elseif ( $request->type == 'Product' ){
                $type_id = $request->product_id;
            }
            Coupon::create([
                'type' => $request->type,
                'type_id' => $type_id,
                'over_all' => $over_all,
                'code' => $request->code,
                'value' => $request->value,
                'value_type' => $request->value_type,
                'quantity' => $request->quantity,
                'begin_date' => $request->begin_date,
                'end_date' => $request->end_date
            ]);

            return Response::json(['status' => true, 'message' => 'Coupon created',
                'redirect' => route('coupons.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Coupon not created', 'detail', $e]);
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
        $data = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('data'));
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
                'type' => ['required'],
                'over_all' => ['required'],
                'code' => ['required', 'string', 'max:255'],
                'value' => ['required', 'numeric', 'between:0,999999.999999'],
                'value_type' => ['required'],
                'quantity' => ['required', 'integer'],
                'begin_date' => ['required', 'date'],
                'end_date' => ['required', 'date']
            ]);

            $type_id = 0;
            $over_all = 0;
            if ( $request->type == 'All' ){
                $type_id = 0;
                $over_all = 1;
            }
            elseif ( $request->type == 'Category' ){
                $type_id = $request->category_id;
            }
            elseif ( $request->type == 'Brand' ){
                $type_id = $request->brand_id;
            }
            elseif ( $request->type == 'Product' ){
                $type_id = $request->product_id;
            }
            Coupon::where('id', $id)->update([
                'type' => $request->type,
                'type_id' => $type_id,
                'over_all' => $over_all,
                'code' => $request->code,
                'value' => $request->value,
                'value_type' => $request->value_type,
                'quantity' => $request->quantity,
                'begin_date' => $request->begin_date,
                'end_date' => $request->end_date
            ]);

            return Response::json(['status' => true, 'message' => 'Coupon updated',
                'redirect' => route('coupons.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Coupon not updated', 'detail', $e]);
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
        $data = Coupon::findOrFail($id);
        try {
            $data->delete();
            return Response::json(['status' => true, 'message' => 'Coupon deleted',
                'redirect' => route('coupons.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Coupon not deleted', 'detail', $e]);
        }
    }
}
