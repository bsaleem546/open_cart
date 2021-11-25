<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->orderBy('created_at', 'ASC')->get();
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:users', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'contact' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
        ]);

        try {
            User::create($data);
            return Response::json(['status' => true, 'message' => 'User Created',
                'redirect' => route('users.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'User not Created', 'detail', $e]);
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
        $user = User::findOrFail($id);
        return view('admin.users.edit')->with('user', $user);
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:users', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'contact' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
        ]);

        try {
            User::where('id', $id)->update($data);
            return Response::json(['status' => true, 'message' => 'User updated',
                'redirect' => route('users.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'User not updated', 'detail', $e]);
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
        $user = User::findOrFail($id);
        try {
            $user->delete();
            return Response::json(['status' => true, 'message' => 'User deleted',
                'redirect' => route('users.index')]);
        }
        catch (\Exception $e){
            return Response::json(['status' => false, 'message' => 'User not deleted', 'detail', $e]);
        }
    }
}
