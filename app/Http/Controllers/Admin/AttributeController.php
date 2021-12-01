<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attributes;
use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Attributes::orderBy('created_at', 'ASC')->get();
        return view('admin.attributes.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.create');
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
            'name' => ['required', 'unique:attributes', 'max:255'],
        ]);

        try {
            Attributes::create($data);
            return Response::json(['status' => true, 'message' => 'Attribute Created',
                'redirect' => route('attributes.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Attribute not Created', 'detail', $e]);
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Attributes::findOrFail($id);
        return view('admin.attributes.edit')->with('data', $data);
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
            'name' => ['required', 'unique:attributes', 'max:255'],
        ]);

        try {
            Attributes::where('id', $id)->update($data);
            return Response::json(['status' => true, 'message' => 'Attributes updated',
                'redirect' => route('attributes.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Attributes not updated', 'detail', $e]);
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
        $data = Attributes::findOrFail($id);
        try {
            $op = Options::where('attribute_id', $id)->get();
            if ($op->isEmpty() ){
                $data->delete();
            }
            else {
                $data->_options()->delete();
                $data->delete();
            }

            return Response::json(['status' => true, 'message' => 'Attributes deleted',
                'redirect' => route('attributes.index')]);
        }
        catch (\Exception $e){
            dd($e);
            return Response::json(['status' => false, 'message' => 'Attributes not deleted', 'detail', $e]);
        }
    }
}
