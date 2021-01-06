<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait HasApiResponses
{
    /**
     * Set the server error response.
     *
     * @param $message
     * @param Exception $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function serverError($message, Exception $exception = null): JsonResponse
    {
        if (null !== $exception) {
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
        }

        $response = [
            'statusCode' => config('todoapp.status_codes.server_error'),
            'statusText' => config('todoapp.status_texts.server_error'),
            'message' => $message,
        ];

        if (null !== $exception) {
            $response['exception'] = $exception->getMessage();
        }

        return Response::json($response, config('todoapp.status_codes.server_error'));
    }

    /**
     * Set the server error response.
     *
     * @param $message
     * @param HttpException $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function httpError($message, HttpException $exception = null): JsonResponse
    {
        if (null !== $exception) {
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
        }

        $response = [
            'statusCode' => $exception->getStatusCode(),
            'statusText' => 'http_error',
            'message' => $message,
        ];

        if (null !== $exception) {
            $response['exception'] = $exception->getMessage();
        }

        return Response::json($response, $exception->getStatusCode());
    }

    /**
     * Set the form validation error response.
     *
     * @param $errors
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function formValidationError($errors, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('todoapp.status_codes.validation_failed'),
            'statusText' => config('todoapp.status_texts.validation_failed'),
            'message' => 'Whoops. Validation failed.',
            'validationErrors' => $errors,
        ];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, config('todoapp.status_codes.validation_failed'));
    }

    /**
     * Set the "not found" error response.
     *
     * @param $message
     * @param string $statusText
     * @param null $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFound($message, $statusText = 'not_found', $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('todoapp.status_codes.not_found'),
            'statusText' => $statusText,
            'message' => $message,
        ];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, config('todoapp.status_codes.not_found'));
    }

    /**
     * Set bad request error response.
     *
     * @param $message
     * @param string $statusText
     * @param null $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function badRequest($message, $statusText = 'bad_request', $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('todoapp.status_codes.bad_request'),
            'statusText' => $statusText,
            'message' => $message,
        ];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, config('todoapp.status_codes.bad_request'));
    }

    /**
     * Set the success response alert.
     *
     * @param $message
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function okResponse($message, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('todoapp.status_codes.success'),
            'statusText' => config('todoapp.status_texts.success'),
            'message' => $message,
        ];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, config('todoapp.status_codes.success'));
    }

    /**
     * Set the created resource response alert.
     *
     * @param $message
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createdResponse($message, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('todoapp.status_codes.created'),
            'statusText' => config('todoapp.status_texts.created'),
            'message' => $message,
        ];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, config('todoapp.status_codes.created'));
    }

    /**
     * Set forbidden request error response.
     *
     * @param $message
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbiddenRequest($message, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('todoapp.status_codes.forbidden'),
            'statusText' => config('todoapp.status_texts.forbidden'),
            'message' => $message,
        ];

        if (null !== $data) {
            $response['data'] = $data;
        }

        return Response::json($response, config('todoapp.status_codes.forbidden'));
    }
}
