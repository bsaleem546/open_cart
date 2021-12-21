<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::orderBy('created_at', 'ASC')->get();
        return view('admin.categories.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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
            $request->validate([
                'name' => ['required', 'unique:categories', 'max:255'],
                'img' => ['required']
            ]);

            $img = time().'.' . $request->img->getClientOriginalExtension();
            \Image::make($request->img)->save(public_path('uploads/category/').$img);

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));

            Category::create([
                'name' => $request->name,
                'img' => $img,
                'slug' => $slug,
            ]);

            return Response::json(['status' => true, 'message' => 'Category Created',
                'redirect' => route('categories.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Category not Created', 'detail', $e]);
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
        $data = Category::findOrFail($id);
        return view('admin.categories.edit')->with('data', $data);
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
            $request->validate([
                'name' => ['required', 'max:255'],
            ]);

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name)));

            $cat = Category::findOrFail($id);
            $cat->name = $request->name;
            $cat->slug = $slug;

            if($request->img != '' ){
                $img = time().'.' . $request->img->getClientOriginalExtension();
                \Image::make($request->img)->save(public_path('uploads/category/').$img);
                $cat->img = $img;
            }
            $cat->update();

            return Response::json(['status' => true, 'message' => 'Category updated',
                'redirect' => route('categories.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Category not updated', 'detail', $e]);
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
        $data = Category::findOrFail($id);
        try {
            $data->delete();
            return Response::json(['status' => true, 'message' => 'Category deleted',
                'redirect' => route('categories.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Category not deleted', 'detail', $e]);
        }
    }
}
