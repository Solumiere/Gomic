<?php

namespace App\Models;

class Review
{
    public int $id;
    public int $user_id;
    public int $comic_id;
    public int $rating; // 1..5
    public string $body;
}
