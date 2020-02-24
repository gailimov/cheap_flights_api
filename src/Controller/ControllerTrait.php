<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

trait ControllerTrait
{
    private function errorResponse(int $code, string $message): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => $message
            ],
            $code
        );
    }
}
