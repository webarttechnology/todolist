<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = "tasks";
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'date',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
