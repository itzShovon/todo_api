<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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

    public function test_create_task(): void{
        $tasks = Todo::create([
            'task' => '$request->task',
            'status' => '$request->status',
            'figure' => 'dsklfldsaife.jpg'
        ]);
        // $tasks->assertOk();
        // error_log($tasks);


        $tasks = $this->get('/tasks');
        $tasks->assertSeeText(404);
        // $response->assertDontSee("No task founded");
    }
}
