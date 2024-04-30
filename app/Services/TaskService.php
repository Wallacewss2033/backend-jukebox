<?php 

namespace App\Services;

use App\Interfaces\TaskInterface;
use App\Repositories\TaskRepository;

class TaskService {

    public function __construct(protected TaskInterface $task)
    { 
    }

    public function getAllTasks()
    {
        return $this->task->all();
    }
}