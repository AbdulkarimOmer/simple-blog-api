<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

trait ExceptionResponseHandler
{
    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToJsonResponse(Request $request, Throwable $e): JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
    {
        return match (true) {
            $this->isNotFoundHttpException($e) => $this->notFoundHttpEndpoint(),
            $this->isModelNotFoundException($e) => $this->modelNotFound(),
            $this->isValidationException($e) => $this->failedValidation($e),
            $this->isAuthorizationException($e) => $this->forbidden(),
            $this->isUnauthorizedException($e) => $this->unauthorized(),
            $this->isUnauthenticatedException($e) => $this->isUnauthenticated(),
            $this->isLogicalException($e) => $this->logicalException($e->getMessage()),
            default => $this->internalServerError()
        };
    }

    /**
     * Determines if the given exception is a http route not found.
     *
     * @param Throwable $e
     * @return bool
     */
    protected function isNotFoundHttpException(Throwable $e): bool
    {
        return $e instanceof NotFoundHttpException;
    }

    /**
     * Returns json response for http route not found exception.
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function notFoundHttpEndpoint(int $statusCode = 404): JsonResponse
    {
        return sendFailedResponse(__('exceptions.route_not_found'), null, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Throwable $e
     * @return bool
     */
    protected function isModelNotFoundException(Throwable $e): bool
    {
        return $e instanceof ModelNotFoundException;
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function modelNotFound(int $statusCode = 404): JsonResponse
    {
        return sendFailedResponse(__('exceptions.record_not_found'), null, $statusCode);
    }

    /**
     * Determines if the given exception is an authorization or unauthorized exception.
     *
     * @param Throwable $e
     * @return bool
     */
    protected function isAuthorizationException(Throwable $e): bool
    {
        return $e instanceof AuthorizationException || $e instanceof UnauthorizedException;
    }

    /**
     * Returns json response for forbidden exception.
     *
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function forbidden(int $statusCode = 403): JsonResponse
    {
        return sendFailedResponse(__('exceptions.forbidden'), null, $statusCode);
    }

    /**
     * Determines if the given exception is an unauthorized http or authentication exception.
     *
     * @param Throwable $e
     * @return bool
     */
    protected function isUnauthorizedException(Throwable $e): bool
    {
        return $e instanceof UnauthorizedHttpException;
    }

    /**
     * Determines if the given exception is an unauthorized http or authentication exception.
     *
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function unauthorized(int $statusCode = 401): JsonResponse
    {
        return sendFailedResponse(__('exceptions.forbidden'), null, $statusCode);
    }

    /**
     * Determines if the given exception is an unauthenticated exception.
     *
     * @param Throwable $e
     * @return bool
     */
    protected function isUnauthenticatedException(Throwable $e): bool
    {
        return $e instanceof AuthenticationException;
    }

    /**
     * Determines if the given exception is an unauthenticated exception.
     *
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function isUnauthenticated(int $statusCode = 401): JsonResponse
    {
        return sendFailedResponse(__('exceptions.login_required'), null, $statusCode);
    }

    /**
     * Determines if the given exception is a validation exception.
     *
     * @param Throwable $e
     * @return bool
     */
    protected function isValidationException(Throwable $e): bool
    {
        return $e instanceof ValidationException;
    }

    /**
     * Returns json response for validation errors exception.
     *
     * @param $e
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function failedValidation($e, int $statusCode = 422): JsonResponse
    {
        return sendFailedResponse(__('messages.validation_error'), $e->errors(), $statusCode);
    }

    /**
     * Determines if the given exception is a logical exception.
     *
     * @param Throwable $e
     * @return bool
     */
    protected function isLogicalException(
        Throwable $e
    ): bool {
        return $e instanceof LogicException;
    }

    /**
     * Determines if the given exception is a logic exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function logicalException(string $message, int $statusCode = 400): JsonResponse
    {
        return sendFailedResponse(__($message), null, $statusCode);
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function internalServerError(int $statusCode = 500): JsonResponse
    {
        return sendFailedResponse(__('exceptions.bad_request'), null, $statusCode);
    }
}
