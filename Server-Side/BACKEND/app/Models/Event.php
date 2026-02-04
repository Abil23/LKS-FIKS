<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    // Kolom mana saja yang boleh diisi datanya
    protected $fillable = [
        'event_name',
        'event_date',
        'organizer',
        'description',
    ];
}