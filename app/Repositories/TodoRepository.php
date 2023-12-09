<?php

namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Support\Str;

class TodoRepository
{
    public function create(array $data)
    {
        $data['uuid'] = Str::uuid();
        return Todo::create($data);
    }

    public function update(Todo $todo, array $data)
    {
        $todo->update($data);
        return $todo;
    }

    public function delete(Todo $todo)
    {
        $todo->delete();
    }

    public function archive(Todo $todo)
    {
        $todo->update(['archived' => true]);
        return $todo;
    }

    public function unarchive(Todo $todo)
    {
        $todo->update(['archived' => false]);
        return $todo;
    }

    public function getAllActive()
    {
        return Todo::where('archived', false)->get();
    }

    public function getAllArchived()
    {
        return Todo::where('archived', true)->get();
    }

    public function findOrFail($uuid)
    {
        return Todo::findOrFail($uuid);
    }
}
