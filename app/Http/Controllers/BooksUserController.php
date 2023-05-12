<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Http\Resources\BooksResource;

use Illuminate\Http\Request;

class BooksUserController extends Controller
{
    public function index(Request $request)
    {
        $order = $request->query('order') ? $request->query('order') : 'desc';

        return BooksResource::collection(
            Book::select('id', 'user_id', 'title', 'author', 'published', 'description', 'isbn', 'created_at', 'updated_at')
                ->orderBy('created_at', $order)
                ->paginate(5)
        );
    }
}
