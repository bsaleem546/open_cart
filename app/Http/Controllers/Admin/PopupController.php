<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PopupController extends Controller
{
    public function index()
    {
        $data = Popup::latest()->get();
        return view('admin.popups.index', compact('data'));
    }

    public function create()
    {
        return view('admin.popups.create');
    }

    public function store(Request $request)
    {
        try {
            $img = time().'.' . $request->img->getClientOriginalExtension();
            \Image::make($request->img)->save(public_path('uploads/popups/').$img);

            Popup::create([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'optional_sub_title' => $request->optional_sub_title,
                'img' => $img,
                'btn_text' => $request->btn_text,
                'btn_link' => $request->btn_link,
                'status' => $request->status
            ]);
            return Response::json(['status' => true, 'message' => 'Popup Created',
                'redirect' => route('popups.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Popup not Created', 'detail', $e]);
        }
    }

    public function destroy($id)
    {
        try {
            $data = Popup::find($id);
            $data->delete();
            return Response::json(['status' => true, 'message' => 'Popup deleted',
                'redirect' => route('popups.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Popup not deleted', 'detail', $e]);
        }
    }

    public function edit($id)
    {
        $data = Popup::find($id);
        return view('admin.popups.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Popup::find($id);
            $data->title = $request->title;
            $data->sub_title = $request->sub_title;
            $data->optional_sub_title = $request->optional_sub_title;

            if ($request->img !== null){
                $img = time().'.' . $request->img->getClientOriginalExtension();
                \Image::make($request->img)->save(public_path('uploads/popups/').$img);
                $data->img = $img;
            }

            $data->btn_text = $request->btn_text;
            $data->btn_link = $request->btn_link;
            $data->status = $request->status;
            $data->update();

            return Response::json(['status' => true, 'message' => 'Popup updated',
                'redirect' => route('popups.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Popup not updated', 'detail', $e]);
        }
    }
}
