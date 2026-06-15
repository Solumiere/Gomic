<?php

namespace App\Models;

class Comic
{
    public int $id;
    public string $title;
    public string $description;
    public float $price;
    public ?string $cover_image_path = null;
    public string $pdf_path;
}
