<?php

namespace App\Repositories;

use App\Models\PropertyMultiple;

class RegisterFormMultipleRepository
{
    public function storeOrUpdate(array $data): PropertyMultiple
    {
        return PropertyMultiple::updateOrCreate($data);
    }

    public function store(array $data): PropertyMultiple
    {
        $propertyMultiple = new PropertyMultiple;

        return $this->valuable($propertyMultiple, $data);
    }

    public function valuable(PropertyMultiple $propertyMultiple, array $param = []): PropertyMultiple
    {
        $param = (object)$param;
        !isset($param->agent_id) ?: $propertyMultiple->agent_id = $param->agent_id;
        !isset($param->project_type_id) ?: $propertyMultiple->project_type_id = $param->project_type_id;
        !isset($param->property_type) ?: $propertyMultiple->property_type = $param->property_type;
        !isset($param->no_of_listing) ?: $propertyMultiple->no_of_listing = $param->no_of_listing;
        !isset($param->used_before) ?: $propertyMultiple->used_before = $param->used_before;
        !isset($param->comment) ?: $propertyMultiple->comment = $param->comment;
        !isset($param->agreement_check) ?: $propertyMultiple->agreement_check = $param->agreement_check;
        !isset($param->status) ?: $propertyMultiple->status = $param->status;
        !isset($param->date) ?: $propertyMultiple->date = $param->date;

        $propertyMultiple->save();

        return $propertyMultiple;
    }
}
