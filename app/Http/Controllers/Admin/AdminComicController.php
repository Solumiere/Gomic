<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminComicController
{
    public function index()
    {
        $comics = Comic::query()->latest()->paginate(15);
        return view('admin.comics.index', compact('comics'));
    }

    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.comics.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:200'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'pages_count' => ['nullable','integer','min:1'],
            'published_year' => ['nullable','integer','min:1900','max:'.date('Y')],
            'is_active' => ['nullable','boolean'],
            'cover' => ['nullable','image','max:4096'],
            'pdf' => ['required','file','mimes:pdf','max:51200'],
            'genres' => ['nullable','array'],
            'genres.*' => ['integer','exists:genres,id'],
        ], [
            'published_year.max' => 'Год выпуска не может быть в будущем',
        ]);

        $slug = Str::slug($data['title']);
        if (Comic::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::random(5);
        }

        $coverPath = null;
        if ($request->file('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $pdfPath = $request->file('pdf')->store('comics', 'private');

        $comic = Comic::create([
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'cover_image_path' => $coverPath,
            'pdf_path' => $pdfPath,
            'pages_count' => $data['pages_count'] ?? null,
            'published_year' => $data['published_year'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? true),
        ]);

        $comic->genres()->sync($data['genres'] ?? []);

        return redirect()->route('admin.comics.index')->with('success', 'Комикс добавлен');
    }

    public function edit(Comic $comic)
    {
        $genres = Genre::orderBy('name')->get();
        $comic->load('genres');
        return view('admin.comics.edit', compact('comic', 'genres'));
    }

    public function update(Request $request, Comic $comic)
    {
        $data = $request->validate([
            'title' => ['required','string','max:200'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'pages_count' => ['nullable','integer','min:1'],
            'published_year' => ['nullable','integer','min:1900','max:'.date('Y')],
            'is_active' => ['nullable','boolean'],
            'cover' => ['nullable','image','max:4096'],
            'pdf' => ['nullable','file','mimes:pdf','max:51200'],
            'genres' => ['nullable','array'],
            'genres.*' => ['integer','exists:genres,id'],
        ], [
            'published_year.max' => 'Год выпуска не может быть в будущем',
        ]);

        if ($request->file('cover')) {
            if ($comic->cover_image_path) {
                Storage::disk('public')->delete($comic->cover_image_path);
            }
            $comic->cover_image_path = $request->file('cover')->store('covers', 'public');
        }

        if ($request->file('pdf')) {
            Storage::disk('private')->delete($comic->pdf_path);
            $comic->pdf_path = $request->file('pdf')->store('comics', 'private');
        }

        $comic->fill([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'pages_count' => $data['pages_count'] ?? null,
            'published_year' => $data['published_year'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? false),
        ])->save();

        $comic->genres()->sync($data['genres'] ?? []);

        return redirect()->route('admin.comics.index')->with('success', 'Комикс обновлён');
    }

    public function destroy(Comic $comic)
    {
        if ($comic->cover_image_path) Storage::disk('public')->delete($comic->cover_image_path);
        if ($comic->pdf_path) Storage::disk('private')->delete($comic->pdf_path);
        $comic->delete();
        return back()->with('success', 'Комикс удалён');
    }
}
