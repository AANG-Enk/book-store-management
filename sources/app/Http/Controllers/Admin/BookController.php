<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $categoryId = $request->string('category_id')->toString();
        $supplierId = $request->string('supplier_id')->toString();
        $status = $request->string('status')->toString();

        $books = Book::query()
            ->with(['category', 'supplier'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('publisher', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($categoryId !== '', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($supplierId !== '', function ($query) use ($supplierId) {
                $query->where('supplier_id', $supplierId);
            })
            ->when($status !== '', function ($query) use ($status) {
                if ($status === 'active') {
                    $query->where('is_active', true);
                }

                if ($status === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $suppliers = Supplier::query()
            ->orderBy('name')
            ->get();

        return view('admin.books.index', compact(
            'books',
            'categories',
            'search',
            'categoryId',
            'status',
            'suppliers',
            'supplierId'
        ));
    }

    public function create(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $suppliers = Supplier::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.books.create', compact('categories','suppliers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBook($request);

        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('books/covers', 'public');
        }

        Book::query()->create($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book): RedirectResponse
    {
        return redirect()->route('admin.books.edit', $book);
    }

    public function edit(Book $book): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orWhere('id', $book->category_id)
            ->orderBy('name')
            ->get();

        $suppliers = Supplier::query()
            ->where('is_active', true)
            ->orWhere('id', $book->supplier_id)
            ->orderBy('name')
            ->get();

        return view('admin.books.edit', compact('book', 'categories', 'suppliers'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $this->validateBook($request, $book);

        $validated['slug'] = $this->generateUniqueSlug($validated['title'], $book->id);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $validated['cover_image'] = $request->file('cover_image')
                ->store('books/covers', 'public');
        }

        $book->update($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        if ($book->orderItems()->exists()) {
            return redirect()
                ->route('admin.books.index')
                ->with('error', 'Buku tidak bisa dihapus karena sudah pernah masuk ke pesanan.');
        }

        if ($book->cartItems()->exists()) {
            return redirect()
                ->route('admin.books.index')
                ->with('error', 'Buku tidak bisa dihapus karena masih ada di keranjang customer.');
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    private function validateBook(Request $request, ?Book $book = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title' => [
                'required',
                'string',
                'max:200',
                Rule::unique('books', 'title')->ignore($book?->id),
            ],
            'author' => ['nullable', 'string', 'max:150'],
            'publisher' => ['nullable', 'string', 'max:150'],
            'publication_year' => ['nullable', 'integer', 'min:1900', 'max:' . now()->year],
            'isbn' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('books', 'isbn')->ignore($book?->id),
            ],
            'description' => ['nullable', 'string', 'max:3000'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'supplier_id' => ['nullable', 'integer', 'exists:suppliers,id'],
        ]);
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Book::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
