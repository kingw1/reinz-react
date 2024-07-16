<?php

namespace App\Repositories;

use App\Models\PropertyRegisterForm;

class PropertyRegisterFormRepository
{
    public function paginate(array $filters = [], $perPage = 10)
    {
        return PropertyRegisterForm::query()
            ->with('agent', 'projectType')
            ->when($filters['search'] ?? null, function ($query, $value) {
                return $query->where('property_type', 'like', "%{$value}%")
                    ->orwhereHas('agent', function ($query) use ($value) {
                        $query->where('company_name', 'like', "%{$value}%");
                    })
                    ->orwhereHas('projectType', function ($query) use ($value) {
                        $query->where('name_' . app()->getLocale(), 'like', "%{$value}%");
                    })
                    ->orWhere('form_type', 'like', "%{$value}%");
            })
            ->when($filters['agent_id'] ?? null, function ($query, $value) {
                return $query->where('agent_id', $value);
            })
            ->when($filters['project_type_id'] ?? null, function ($query, $value) {
                return $query->where('project_type_id', $value);
            })
            ->when($filters['property_type'] ?? null, function ($query, $value) {
                return $query->where('property_type', $value);
            })
            ->latest()
            ->paginate($perPage);
    }
}
