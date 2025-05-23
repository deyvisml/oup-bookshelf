<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation_rules = [
            'public_id' => 'required|string',
            'title' => 'required|string',
            'version' => 'required|numeric',
            'size' => 'required|numeric',
            'folder' => 'required|string',
            'type_readers' => 'required|boolean',
            'type_gradebook' => 'required|boolean',
            'type_gradebook_answer_revealable' => 'required|boolean',
            'type_classroom_presentation' => 'required|boolean',
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

        // Asigna el valor de zip_download_url
        $request->merge([
            'thumbnail_url' => 'books/' . $request->folder . '/' . $request->public_id . '.jpg',
            'original_thumbnail_url' => $request->original_thumbnail_url,
            'zip_download_url' => 'books/' . $request->folder . '/' . $request->public_id . '.zip',
            'original_zip_download_url' => $request->original_zip_download_url,
            'cefr_level' => $request->cefr_level,
        ]);

        $book = Book::create($request->all());

        $response = [
            'status' => true, 
            'message' => "Record created successfully.",
            'data' => [
                'book' => $book,
            ],
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
