<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Options::orderBy('created_at', 'ASC')->get();
        return view('admin.options.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.options.create');
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
            'attribute_id' => ['required'],
            'name' => ['required', 'string'],
//            'quantity' => ['integer'],
//            'price' => ['required'],
//            'in_stock' => ['required']
        ]);
        try {
            Options::create($data);
            return Response::json(['status' => true, 'message' => 'Option Created',
                'redirect' => route('options.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Option not Created', 'detail', $e]);
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
        $data = Options::findOrFail($id);
        return view('admin.options.edit')->with('data', $data);
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
            'attribute_id' => ['required'],
            'name' => ['required', 'string'],
//            'quantity' => ['integer'],
//            'price' => ['required'],
//            'in_stock' => ['required']
        ]);

        try {
            Options::where('id', $id)->update($data);
            return Response::json(['status' => true, 'message' => 'Options updated',
                'redirect' => route('options.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Options not updated', 'detail', $e]);
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
        $data = Options::findOrFail($id);
        try {
            $data->delete();
            return Response::json(['status' => true, 'message' => 'Options deleted',
                'redirect' => route('options.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Options not deleted', 'detail', $e]);
        }
    }
}
