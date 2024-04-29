<?php 

namespace App\Interfaces;

interface BaseInterface {
    public function create(array $data);
    public function find(int $id);
    public function update(array $data);
    public function delete(int $id);
    public function all();
}