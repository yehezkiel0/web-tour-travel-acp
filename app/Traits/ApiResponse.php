<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait ApiResponse
{
  /**
   * Success response
   */
  protected function successResponse($data = null, string $message = 'Success', int $code = 200): JsonResponse
  {
    $response = [
      'success' => true,
      'message' => $message,
    ];

    if ($data !== null) {
      $response['data'] = $data;
    }

    return response()->json($response, $code);
  }

  /**
   * Error response
   */
  protected function errorResponse(string $message, int $code = 400, $errors = null): JsonResponse
  {
    $response = [
      'success' => false,
      'message' => $message,
    ];

    if ($errors !== null) {
      $response['errors'] = $errors;
    }

    return response()->json($response, $code);
  }

  /**
   * Paginated response
   */
  protected function paginatedResponse(LengthAwarePaginator $paginator, string $message = 'Success'): JsonResponse
  {
    return response()->json([
      'success' => true,
      'message' => $message,
      'data' => $paginator->items(),
      'pagination' => [
        'total' => $paginator->total(),
        'per_page' => $paginator->perPage(),
        'current_page' => $paginator->currentPage(),
        'last_page' => $paginator->lastPage(),
        'from' => $paginator->firstItem(),
        'to' => $paginator->lastItem(),
        'has_more_pages' => $paginator->hasMorePages(),
      ],
    ]);
  }

  /**
   * Created response
   */
  protected function createdResponse($data = null, string $message = 'Resource created successfully'): JsonResponse
  {
    return $this->successResponse($data, $message, 201);
  }

  /**
   * Updated response
   */
  protected function updatedResponse($data = null, string $message = 'Resource updated successfully'): JsonResponse
  {
    return $this->successResponse($data, $message, 200);
  }

  /**
   * Deleted response
   */
  protected function deletedResponse(string $message = 'Resource deleted successfully'): JsonResponse
  {
    return $this->successResponse(null, $message, 200);
  }

  /**
   * Not found response
   */
  protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
  {
    return $this->errorResponse($message, 404);
  }

  /**
   * Validation error response
   */
  protected function validationErrorResponse($errors, string $message = 'Validation failed'): JsonResponse
  {
    return $this->errorResponse($message, 422, $errors);
  }

  /**
   * Unauthorized response
   */
  protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
  {
    return $this->errorResponse($message, 401);
  }

  /**
   * Forbidden response
   */
  protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
  {
    return $this->errorResponse($message, 403);
  }

  /**
   * Server error response
   */
  protected function serverErrorResponse(string $message = 'Internal server error'): JsonResponse
  {
    return $this->errorResponse($message, 500);
  }
}
