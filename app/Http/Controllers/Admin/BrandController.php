<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Brand::orderBy('created_at', 'ASC')->get();
        return view('admin.brands.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'unique:brands', 'max:255'],
        ]);

        try {
            Brand::create($data);
            return Response::json(['status' => true, 'message' => 'Brand Created',
                'redirect' => route('brands.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Brand not Created', 'detail', $e]);
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
        $data = Brand::findOrFail($id);
        return view('admin.brands.edit')->with('data', $data);
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
        $data = $request->validate([
            'name' => ['required', 'unique:brands', 'max:255'],
        ]);

        try {
            Brand::where('id', $id)->update($data);
            return Response::json(['status' => true, 'message' => 'Brand updated',
                'redirect' => route('brands.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Brand not updated', 'detail', $e]);
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
        $data = Brand::findOrFail($id);
        try {
            $data->delete();
            return Response::json(['status' => true, 'message' => 'Brand deleted',
                'redirect' => route('brands.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Brand not deleted', 'detail', $e]);
        }
    }
}
