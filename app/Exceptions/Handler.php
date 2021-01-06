<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Traits\HasApiResponses;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    use HasApiResponses;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->notFound("We cannot access the resource you are looking for", 'resource_not_found');
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->notFound("Unable to locate model resource", 'model_not_found');
        }

        if ($exception instanceof HttpException) {
            return $this->httpError($exception->getMessage(), $exception);
        }

        if ($exception instanceof ValidationException) {
            return $this->formValidationError($exception->errors());
        }

        if ($exception instanceof QueryException) {
            return $this->serverError("Something went wrong while querying the database", $exception);
        }

        return parent::render($request, $exception);
    }
}
