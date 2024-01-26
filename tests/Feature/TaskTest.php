<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TaskTest extends TestCase
{

    use RefreshDatabase;


    public function check_tasks_route(): void
    {
        // $response = $this->get('/');
        // $response->assertStatus(200);

        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    public function test_if_todo_working(): void
    {
        $response = Todo::create([
            'task' => 'task 5.1',
            'status' => 'pending',
            'figure' => 'dfukcingmeasery.jpg'
        ]);

        $response->update([
            'task' => 'task 5.1.1',
            'status' => 'Updated',
            'figure' => 'addedoldphotoasnew.jpg',
        ]);

        $response->delete();

        $response = $this->get('/tasks');

        $response->assertSee('404');
    }

    // public function test_if_file_upload_working(): void
    // {
    //     Storage::fake('avatars');

    //     $file = UploadedFile::fake()->image('avatar.jpg');

    //     $response = $this->post('/avatar', [
    //         'avatar' => $file,
    //     ]);

    //     Storage::disk('avatars')->assertExists($file->hashName());
    // }



    public function check_has_tasks(): void
    {
        $tasks = Todo::factory()->create();
        $this->assertNotEmpty($tasks->task);
    }

    public function check_empty_tasks(): void
    {
        $tasks = $this->get('/tasks');
        $tasks->assertSee('404');
    }


}
