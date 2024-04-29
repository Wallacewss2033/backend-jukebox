<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;
    protected $task;
    protected $taskId = 1;
    protected $user;
    protected $userId;
    protected $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->userId = $this->user->first()->id;

        $this->repository = $this->app->make(TaskRepository::class);

        $this->task = Task::factory()->count(12)->create([
            'users_id' => $this->userId
        ]);

        $this->taskId = $this->task->first()->id;

        $this->data = [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'users_id' => $this->userId
        ];
    }

    public function test_repository_task_all(): void
    {
        $this->assertCount(10, $this->repository->all()->toArray()['data']);
    }

    public function test_repository_task_by_id(): void
    {
        $task = $this->repository->find($this->taskId);
        $this->assertEquals($this->taskId, $task->id);
    } 

    public function test_repository_create_task(): void
    {
        $task = $this->repository->create($this->data);
        $this->assertEquals([
            'title' => $task->title,
            'description' => $task->description,
            'users_id' => $task->users_id
        ], $this->data);
    }

    public function test_repository_update_task(): void
    {
        $data =[
            'id' => $this->taskId,
            'title' => fake()->title(),
            'description' => fake()->text(),
            'users_id' => $this->userId
        ];

        
        $newTask = $this->repository->update($data);
        
        $this->assertTrue($newTask, 'atualizado!');
        $this->assertDatabaseHas('tasks', $data);
    }

    public function test_repository_delete_task(): void 
    {   
        $taskId = $this->task->first()->id;
        $deleteTask = $this->repository->delete($taskId);
        $this->assertTrue($deleteTask);
    }


}
