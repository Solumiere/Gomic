<?php

namespace App\Models;

class User
{
    public int $id;
    public string $email;
    public bool $is_admin = false;
}
