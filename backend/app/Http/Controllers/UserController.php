<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation_rules = [
            'email' => 'required|email|unique:users',
        ];

        $validation = Validator::make($request->all(), $validation_rules);

        if ($validation->fails()) {
            $response = [
                'status' => false,
                'message' => 'Error de validación.',
                'error' => [
                    'type' => 'validation-error',
                    'data' => $validation->errors(),
                ],
            ];
            return response()->json($response);
        }

        $user = User::create([
            'email' => $request->input('email'),
            'first_name' => $request->input('first_name', ''),
            'last_name' => $request->input('last_name', ''),
        ]);

        $response = [
            'status' => true, 
            'message' => "Record created successfully.",
            'data' => [
                'user' => $user,
            ],
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $response = [
            'status' => true,
            'message' => "User found.",
            'data' => [
                'user' => $user,
            ],
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
