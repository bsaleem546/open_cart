<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReviewController extends Controller
{
    public function index()
    {
        $data = Review::latest()->get();
        return view('admin.reviews.index', compact('data'));
    }

    public function updateStatus(Request $request)
    {
        try {
            Review::where('id', $request->id)->update([ 'status' => $request->status ]);

            return Response::json(['status' => true, 'message' => 'Status Updated',
                'redirect' => route('reviews.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'Status not Updated', 'detail', $e]);
        }
    }
}
