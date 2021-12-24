<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Slider::latest()->get();
        return view('admin.sliders.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sliders.create');
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
                'img' => ['required'],
            ]);
            $img = time().'.' . $request->img->getClientOriginalExtension();
            \Image::make($request->img)->save(public_path('uploads/slides/').$img);

            Slider::create([
                'img' => $img,
                'text1' => $request->text1,
                'text2' => $request->text2,
                'text3' => $request->text3,
                'text4' => $request->text4,
                'btn_text' => $request->btn_text,
                'btn_link' => $request->btn_link,
            ]);
            return Response::json(['status' => true, 'message' => 'Slide Created',
                'redirect' => route('sliders.index')]);
        }
        catch(\Exception $e){
            return Response::json(['status' => false, 'message' => 'Slide not Created', 'detail', $e]);
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
        $data = Slider::find($id);
        return view('admin.sliders.edit', compact('data'));
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

            $slider = Slider::find($id);
            if ($request->img != null){
                $img = time().'.' . $request->img->getClientOriginalExtension();
                \Image::make($request->img)->save(public_path('uploads/slides/').$img);
                $slider->img = $img;
            }
            $slider->text1 = $request->text1;
            $slider->text2 = $request->text2;
            $slider->text3 = $request->text3;
            $slider->text4 = $request->text4;
            $slider->btn_text = $request->btn_text;
            $slider->btn_link = $request->btn_link;
            $slider->update();

            return Response::json(['status' => true, 'message' => 'Slide Updated',
                'redirect' => route('sliders.index')]);
        }
        catch(\Exception $e){
            return Response::json(['status' => false, 'message' => 'Slide not Updated', 'detail', $e]);
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
            $data = Slider::find($id);
            $data->delete();
            return Response::json(['status' => true, 'message' => 'Slide deleted',
                'redirect' => route('sliders.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Slide not deleted', 'detail', $e]);
        }
    }
}
