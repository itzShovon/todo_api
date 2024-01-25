<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    // added table name and fillable methods

    protected $table = 'todos';

    protected $fillable = [
        'task',
        'status',
        'figure',
    ];
}
