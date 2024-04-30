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

    public function setTask(array $data) {
        return $this->task->create($data);
    }

    public function getTask(int $id) {
        return $this->task->find($id);
    }
}