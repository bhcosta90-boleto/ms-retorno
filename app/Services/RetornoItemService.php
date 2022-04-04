<?php

namespace App\Services;

use App\Models\RetornoItem as Model;

final class RetornoItemService
{
    public function __construct(private Model $repository)
    {
    }

    public function store($data)
    {
        return $this->repository->create($data);
    }
}
