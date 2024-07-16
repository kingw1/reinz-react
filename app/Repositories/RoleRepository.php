<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository
{
    public function find(int $id): Role
    {
        return Role::findOrFail($id);
    }

    public function selectRoles(): array
    {
        return Role::pluck('name', 'id')->toArray();
    }

    public function getAll(): Collection
    {
        return Role::all();
    }

    public function paginate(array $filters = [], $perPage = 10): LengthAwarePaginator
    {
        return Role::query()
            ->with(['permissions'])
            ->when($filters['search'], function ($query, $value) {
                return $query->where('name', 'like', "%{$value}%");
            })
            ->paginate($perPage);
    }

    public function store(array $data): Role
    {
        $role = new Role;

        return $this->valuable($role, $data);
    }

    public function update(int $id, array $data): Role
    {
        $role = $this->find($id);

        return $this->valuable($role, $data);
    }

    public function valuable(Role $role, array $param = []): Role
    {
        $param = (object) $param;

        !isset($param->name) ?: $role->name = $param->name;

        $role->save();

        if (isset($param->permissions)) {
            $role->permissions()->sync($param->permissions);
        }

        return $role;
    }
}
