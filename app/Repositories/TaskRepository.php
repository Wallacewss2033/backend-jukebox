<?php 

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;

class TaskRepository implements TaskInterface {
    public function all()
    {
        return Task::where('users_id', auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function find(int $id)
    {
        return Task::where('users_id', auth()->user()->id)->findOrFail($id);        
    }

    public function update(array $data)
    {
        return Task::where('users_id', auth()->user()->id)->findOrFail($data['id'])->update($data);
    }

    public function delete(int $id)
    {
        return Task::where('users_id', auth()->user()->id)->findOrFail($id)->delete();        
    }
}