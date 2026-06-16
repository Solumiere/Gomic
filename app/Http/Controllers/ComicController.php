<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComicController
{
    public function index(Request $request)
    {
        $q = Comic::query()->where('is_active', true);

        if ($search = trim((string)$request->get('q'))) {
            $q->where('title', 'like', '%'.$search.'%');
        }

        $min = $request->get('min');
        $max = $request->get('max');
        if ($min !== null && $min !== '') $q->where('price', '>=', (float)$min);
        if ($max !== null && $max !== '') $q->where('price', '<=', (float)$max);

        $sort = $request->get('sort', 'price_asc');
        if ($sort === 'price_desc') $q->orderBy('price', 'desc');
        else $q->orderBy('price', 'asc');

        $comics = $q->paginate(9)->withQueryString();

        return view('comics.index', compact('comics', 'sort', 'search', 'min', 'max'));
    }

    public function show(Comic $comic)
    {
        $avgRating = (float) $comic->reviews()->where('is_hidden', false)->avg('rating');
        $reviews = $comic->reviews()->where('is_hidden', false)->with('user')->latest()->get();

        return view('comics.show', compact('comic', 'avgRating', 'reviews'));
    }
}
