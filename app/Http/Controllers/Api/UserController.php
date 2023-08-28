<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signIn(Request $request)
    {
        if (!$request->isMethod('post')) {
            return response()->json([
                'code' => '400',
                'message' => 'Bad Request. Only Post method allowed'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|unique:users|regex:/[a-z0-9]+@[a-z]+\.[a-z]{2,3}/u',
            'password' => 'required|min:6|max:10',
            'retype_password' => 'required|same:password',
            'address' => 'required',
            'phone_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => '422',
                'message' => 'Validation Fails',
                'error' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $user = new User;
        $user = $user->createUser($data);

        return response()->json([
            'code' => '201',
            'message' => 'User created Successfully'
        ], 201);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}