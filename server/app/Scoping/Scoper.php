<?php

namespace App\Scoping;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class Scoper
{
    public function __construct(protected Request $request)
    {
        Log::debug('REQUEST KEYS AND VALUES', $this->request->all());
    }

    public function apply(Builder $builder, array $scopes): Builder
    {
        foreach ($this->limitScopes($scopes) as $key => $scope) {
            if (!$scope instanceof Scope) {
                continue;
            }

            $scope->apply($builder, $this->request->get($key));
            Log::debug('REQUEST KEY', [$this->request->get($key)]);
        }


        return $builder;
    }

    private function limitScopes(array $scopes): array
    {
        return Arr::only(
            $scopes,
            array_keys($this->request->all())
        );
    }
}
