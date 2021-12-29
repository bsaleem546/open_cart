<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postReview(Request $request)
    {
        try {
            Review::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'rating' => ($request->ratedIndex+1),
                'review' => $request->txt,
            ]);
            return Response::json(['status' => true]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false]);
        }
    }
}
