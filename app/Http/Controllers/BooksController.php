<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\BooksResource;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;

class BooksController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order = $request->query('order') ? $request->query('order') : 'desc';

        return BooksResource::collection(
            Book::select('id', 'user_id', 'title', 'published', 'description', 'isbn', 'created_at', 'updated_at')
                ->orderBy('created_at', $order)
                ->paginate(5)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $request->validated($request->all());

        $book = Book::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'published' => $request->published,
            'author' => $request->author,
            'description' => $request->description,
            'isbn' => $request->isbn,
        ]);

        return new BooksResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //return $this->isNotAuthorized($book) ? $this->isNotAuthorized($book) : new BooksResource($book);

        if(Auth::user()->id !== $book->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }

        return new BooksResource($book);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        if(Auth::user()->id !== $book->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }

        $book->update($request->all());

        return new BooksResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //return $this->isNotAuthorized($book) ? $this->isNotAuthorized($book) : $book->delete();

        if(Auth::user()->id !== $book->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }

        $book->delete();

        return response(null, 403);
    }

    // private function isNotAuthorized($book)
    // {
    //     if(Auth::user()->id !== $book->user_id) {
    //         return $this->error('', 'You are not authorized to make this request', 403);
    //     }
    // }
}
