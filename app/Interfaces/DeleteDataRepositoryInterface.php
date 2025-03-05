<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface DeleteDataRepositoryInterface
{
    public function deleteDataUsers(): JsonResponse;
}
