<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Resources\BooksResource;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;

class BooksAdminController extends Controller
{
    use HttpResponses;

    // public function index(Request $request)
    // {
    //     $order =$request->query('order') ? $request->query('order') : 'desc';

    //     return BooksResource::collection(Book::select('id', 'title', 'published', 'author', 'description', 'isbn')
    //         ->orderBy('created_at', $order)
    //         ->paginate(10));
    // }

    public function index(Request $request)
    {
        $order = $request->query('order') ? $request->query('order') : 'desc';

        return BooksResource::collection(
            Book::select('id', 'title', 'author', 'published', 'description', 'isbn', 'created_at', 'updated_at')
                ->orderBy('created_at', $order)
                ->paginate(5)
        );
    }

    public function show(string $id)
    {
        return response(BooksResource::make(Book::find($id)), 200);
    }

    public function update(Request $request, string $id)
    {
        $fields = $request->validate([
            'title' => 'nullable|string',
            'published' => 'nullable|string',
            'author' => 'nullable|string',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string'
        ]);

        $book = Book::find($id);
        $book->update($request->all());

        return response($book, 200);
    }

    public function store(StoreBookRequest $request)
    {
        $request->validated($request->all());

        $book = Book::create([
            'title' => $request->title,
            'published' => $request->published,
            'author' => $request->author,
            'description' => $request->description,
            'isbn' => $request->isbn
        ]);

        return response($book, 201);
    }
    
    public function destroy(string $id)
    {
        Book::destroy($id);

        $response = [
            'message' => 'Book has been deleted'
        ];

        return response($response, 200);
    }
}
