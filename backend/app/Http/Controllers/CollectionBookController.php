<?php

namespace App\Http\Controllers;

use App\Models\CollectionBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CollectionBookController extends Controller
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
            'book_order' => 'required|integer',
            'collection_id' => 'required|integer|exists:collections,id',
            'book_id' => [
                'required',
                'integer',
                'exists:books,id',
                Rule::unique('collection_book')->where(function ($query) use ($request) {
                    return $query->where('collection_id', $request->collection_id);
                }),
            ],
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

        $collectionBook = CollectionBook::create($request->all());

        $response = [
            'status' => true, 
            'message' => "Registro creado exitosamente.",
            'data' => [
                'collection_book' => $collectionBook,
            ],
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CollectionBook $collectionBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CollectionBook $collectionBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CollectionBook $collectionBook)
    {
        //
    }
}
