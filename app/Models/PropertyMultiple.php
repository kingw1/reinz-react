<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyMultiple extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'project_type_id',
        'property_type',
        'no_of_listing',
        'used_before',
        'comment',
        'agreement_check',
        'status',
        'date',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (PropertyMultiple $propertyMultiple) {
            $propertyRegisterForm = new PropertyRegisterForm;
            $propertyRegisterForm->propertyable_id = $propertyMultiple->id;
            $propertyRegisterForm->propertyable_type = get_class($propertyMultiple);
            $propertyRegisterForm->agent_id = $propertyMultiple->agent_id;
            $propertyRegisterForm->project_type_id = $propertyMultiple->project_type_id;
            $propertyRegisterForm->property_type = $propertyMultiple->property_type;
            $propertyRegisterForm->form_type = 'multiple';
            $propertyRegisterForm->save();
        });
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function projectType(): BelongsTo
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }
}
