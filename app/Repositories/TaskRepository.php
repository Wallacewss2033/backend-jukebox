<?php 

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;

class TaskRepository implements TaskInterface {
    public function all()
    {
        return Task::paginate(10);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function find(int $id)
    {
        return Task::find($id);        
    }

    public function update(array $data)
    {
        return Task::find($data['id'])->update($data);
    }

    public function delete(int $id)
    {
        return Task::find($id)->delete();        
    }
}