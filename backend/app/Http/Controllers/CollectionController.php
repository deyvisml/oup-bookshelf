<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collections = Collection::all();
        return CollectionResource::collection($collections);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation_rules = [
            'title' => 'required|string',
            'state_id' => 'required|integer|exists:states,id',
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

        $collection = Collection::create($request->all());

        $response = [
            'status' => true, 
            'message' => "Registro creado exitosamente.",
            'data' => [
                'collection' => $collection,
            ],
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        //
    }

    /**
     * Get all collections by email user.
     */
    public function allByUserEmail(Request $request)
    {
        $ACTIVE = 1;
        $email = $request->email;

        // get user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $response = [
                'status' => false, 
                'message' => 'The user does not exits.', 
                'data' => null
            ];
            return response()->json($response, 404);
        }

        // query
        $query = Collection::query();

        // select
        $query->select('collections.*');

        foreach (Schema::getColumnListing('memberships') as $column) {
            $query->addSelect('memberships.' . $column . ' as memberships_' . $column);
        }

        // join
        $query->join('memberships', 'memberships.collection_id', '=', 'collections.id');

        // where
        $query->where('memberships.user_id', $user->id)
            ->where('collections.state_id', $ACTIVE);

        $collections = $query->get();

        //dd($collections);

        foreach ($collections as $collection) {
            $collection->books = $collection->books()->get();
        }

        $response = [
            'status' => true, 
            'message' => "The records were found successfully.", 
            'data' => CollectionResource::collection($collections)
        ];

        return response()->json($response, 200);
    }
}
