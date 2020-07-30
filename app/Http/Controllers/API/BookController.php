<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\AddBookRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Book;
use Illuminate\Contracts\Validation\Validator;

class BookController extends BaseController
{
    public function index()
    {
        $books = Book::all();
        return $this->sendResponse($books->toArray(), 'Books List');
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }

        return $this->sendResponse($book->toArray(), 'Book.');
    }

    public function store(AddBookRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->sendError('Validation Error.', $request->validator->errors(), 400);
        }

        $validated = $request->validated();

        try {
            $book = Book::create($validated);

            return $this->sendResponse($book->toArray(), 'Book created.');
        }catch (\Exception $e){
            return $this->sendError('Creating Error.', $e, 500);
        }

    }
}
