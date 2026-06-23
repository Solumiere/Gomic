<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Comic extends Model
{
    protected $fillable = [
        'title','slug','author','description','price','cover_image_path','pdf_path',
        'pages_count','published_year','is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Полный URL обложки: внешняя ссылка, загруженный файл или авто-обложка
    public function getCoverUrlAttribute(): ?string
    {
        $path = $this->cover_image_path;
        if ($path) {
            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }
            return asset('storage/'.$path);
        }
        return 'https://picsum.photos/seed/comic-'.$this->slug.'/600/900';
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'comic_genre');
    }
}
