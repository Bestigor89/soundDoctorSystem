<?php

namespace App\Models\Scopes\TaskForPatient;

use App\Enums\TaskForPatientStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WithoutHidden implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('task_for_patients.status', '<>', TaskForPatientStatusEnum::HIDDEN);
    }

}
