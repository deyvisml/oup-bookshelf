<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembershipController extends Controller
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
            'expiry_date' => 'required|date',
            'user_id' => 'required|integer|exists:users,id',
            'collection_id' => 'required|integer|exists:collections,id',
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

        $membership = Membership::where('user_id', $request->user_id)
                                ->where('collection_id', $request->collection_id)
                                ->first();

        if ($membership) {
            $membership->expiry_date = $request->expiry_date;
            $membership->save();

            $response = [
                'status' => true, 
                'message' => "Registro actualizado exitosamente.",
                'data' => [
                    'membership' => $membership,
                ],
            ];
            return response()->json($response, 200);
        }

        $membership = Membership::create($request->all());

        $response = [
            'status' => true, 
            'message' => "Registro creado exitosamente.",
            'data' => [
                'membership' => $membership,
            ],
        ];
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        //
    }
}
