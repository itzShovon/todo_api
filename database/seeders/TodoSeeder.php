<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('todos')->insert([
            'task' => Str::random(10),
            'status' => Str::random(10),
            'figure' => Str::random(10).'.jpg',
        ]);
    }
}
