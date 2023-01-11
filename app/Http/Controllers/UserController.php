<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => User::all()->map(function ($user){
                return [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "avatar" => asset('storage/avatar/'.$user->avatar),
                    "active" => $user->active,
                    "gender" => $user->gender,
                ];
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $path = $request->file('avatar')->store('public/avatar');

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'avatar' => pathinfo($path)['basename'],
            'active' => $request->get('active'),
            'gender' => $request->get('gender'),
            'password' => bcrypt('12345678')
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'User is not found.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "avatar" => asset('storage/avatar/'.$user->avatar),
                "active" => $user->active,
                "gender" => $user->gender,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\EditUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EditUserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'User is not found.'
            ]);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('public/avatar');
        }

        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'avatar' => $request->hasFile('avatar') ? pathinfo($path)['basename'] : $user->avatar,
            'active' => $request->get('active'),
            'gender' => $request->get('gender'),
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'User is not found.'
            ]);
        }

        $user->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
