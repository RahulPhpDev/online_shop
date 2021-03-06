<?php

namespace App\Exceptions;

use App\Enums\NotFoundReponseEnum;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
        if ( $exception instanceof NotFoundHttpException)
        {
          return response(NotFoundReponseEnum::response(), 404);
        } elseif ($exception instanceof ValidationException) {
             if ($exception->response) {
                return $exception->response;
                 }
        return $request->expectsJson()
                    ? $this->invalidJson($request, $exception)
                    : $this->invalid($request, $exception);
        }
        return parent::render($request, $exception);
    }

     protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'result'    => 0,
            'msg'  => $this->transformErrors($exception),
            'data' => null,

        ], $exception->status);
    }

   private function transformErrors(ValidationException $exception)
    {
        $errors = null;
        $response = collect($exception->errors())->values()->first();
        return  $response  ? implode("", $response) : '';

    }
}
