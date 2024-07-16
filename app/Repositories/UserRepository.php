<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function find(int $id): User
    {
        return User::findOrFail($id);
    }

    public function getAll(): Collection
    {
        return User::all();
    }

    public function paginate(array $filters = [], $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->when($filters['search'], function ($query, $value) {
                return $query->where('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%");
            })
            ->when($filters['role_id'], function ($query, $value) {
                return $query->where('role_id', $value);
            })
            ->where('email', 'not like', "%zentnova%")
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data): User
    {
        $user = new User;

        return $this->valuable($user, $data);
    }

    public function update(int $id, array $data): User
    {
        $user = $this->find($id);

        return $this->valuable($user, $data);
    }

    public function valuable(User $user, array $param = []): User
    {
        $param = (object) $param;

        !isset($param->name) ?: $user->name = $param->name;
        !isset($param->email) ?: $user->email = $param->email;
        !isset($param->password) ?: $user->password = $param->password;
        !isset($param->role_id) ?: $user->role_id = $param->role_id;

        $user->save();

        return $user;
    }
}
