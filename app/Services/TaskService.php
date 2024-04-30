<?php 

namespace App\Services;

use App\Interfaces\TaskInterface;

class TaskService {

    public function __construct(protected TaskInterface $task)
    { 
    }

    public function getAllTasks()
    {
        return $this->task->all();
    }

    public function setTask(array $data) {
        $data['users_id'] = auth()->user()->id;
        return $this->task->create($data);
    }

    public function getTask(int $id) {
        return $this->task->find($id);
    }

    public function updateTask(array $data, $id) {
        $data['id'] = $id;
        return $this->task->update($data);
    }

    public function deleteTask(int $id) {
        $data['id'] = $id;
        return $this->task->delete($id);
    }
}