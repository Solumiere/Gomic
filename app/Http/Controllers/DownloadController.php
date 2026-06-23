<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        // Внешняя ссылка на файл — отправляем на неё
        if ($path && Str::startsWith($path, ['http://', 'https://'])) {
            return redirect()->away($path);
        }

        // Локальный приватный файл
        if ($path && Storage::disk('private')->exists($path)) {
            return Storage::disk('private')->download($path, $comic->slug.'.pdf');
        }

        // Запасной демо-файл, чтобы скачивание всегда работало
        return redirect()->away('https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf');
    }
}
