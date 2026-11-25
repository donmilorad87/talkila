<?php

namespace App\Scopes;

use App\Entity\CallTypes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class GroupTalksScope implements Scope
{
    /**
     * All the extensions to be added to the builder.
     *
     * @var array
     */
    protected array $extensions = ['WithGroup'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder  $builder
     * @param  Model    $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->when(IsMobileApp(), function (Builder $builder) {
            $builder->where('call_type', '!=', CallTypes::GROUP);
        });
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  Builder  $builder
     *
     * @return void
     */
    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the with-group extension to the builder.
     *
     * @param  Builder  $builder
     *
     * @return void
     */
    protected function addWithGroup(Builder $builder): void
    {
        $builder->macro('withGroup', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
