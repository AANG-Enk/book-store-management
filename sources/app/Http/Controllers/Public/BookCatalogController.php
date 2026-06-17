<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookCatalogController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $categorySlug = $request->string('category')->toString();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $books = Book::query()
            ->with('category')
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('publisher', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->whereHas('category', function ($categoryQuery) use ($categorySlug) {
                    $categoryQuery->where('slug', $categorySlug);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $selectedCategory = $categorySlug
            ? $categories->firstWhere('slug', $categorySlug)
            : null;

        return view('public.books.index', compact(
            'books',
            'categories',
            'search',
            'categorySlug',
            'selectedCategory'
        ));
    }

    public function show(Book $book): View
    {
        abort_if(! $book->is_active, 404);
        abort_if(! $book->category?->is_active, 404);

        $book->load('category');

        $relatedBooks = Book::query()
            ->with('category')
            ->where('is_active', true)
            ->where('category_id', $book->category_id)
            ->whereKeyNot($book->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('public.books.show', compact('book', 'relatedBooks'));
    }
}
