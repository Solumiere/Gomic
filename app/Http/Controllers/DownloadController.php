<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController
{
    public function comicPdf(Request $request, Comic $comic)
    {
        $user = $request->user();

        $hasPaid = Order::query()
            ->where('user_id', $user->id)
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_COMPLETED])
            ->whereHas('items', fn($q) => $q->where('comic_id', $comic->id))
            ->exists();

        if (!$hasPaid) {
            return back()->with('error', 'Скачать можно только после покупки');
        }

        $path = $comic->pdf_path;
        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        $filename = $comic->slug.'.pdf';
        return Storage::disk('private')->download($path, $filename);
    }
}
