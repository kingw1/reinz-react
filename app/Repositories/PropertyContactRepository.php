<?php

namespace App\Repositories;

use App\Models\PropertyContact;

class PropertyContactRepository
{
    public function paginate(array $filters = [], $perPage = 10)
    {
        return PropertyContact::query()
            ->when($filters['search'] ?? null, function ($query, $value) {
                return $query->where('name', 'like', "%{$value}%")
                    ->orWhere('telephone', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%");
            })
            ->when($filters['agent_id'] ?? null, function ($query, $value) {
                return $query->where('agent_id', $value);
            })
            ->when($filters['project_id'] ?? null, function ($query, $value) {
                return $query->where('project_id', $value);
            })
            ->latest()
            ->paginate($perPage);
    }


    public function find(int $id): PropertyContact
    {
        return PropertyContact::findOrFail($id);
    }
}
