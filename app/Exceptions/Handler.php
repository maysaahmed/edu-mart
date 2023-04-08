<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use App\Traits\ApiResponser;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report or log an exception.
     * @param Throwable $e
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }


//    /**
//     * Render an exception into an HTTP response.
//     * @param \Illuminate\Http\Request $request
//     * @param Exception $exception
//     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
//     */
//    public function render($request, Throwable $exception)
//    {
//        $response = $this->handleException($request, $exception);
//        return $response;
//    }
    /**
     * @param $request
     * @param Exception $exception
     * @return \Illuminate\Http\Response|JsonResponse|Response
     * @throws Throwable
     */
    public function handleException($request, Exception $exception): \Illuminate\Http\Response|JsonResponse|Response
    {

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method for the request is invalid.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified URL cannot be found.', Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if($exception instanceof ModelNotFoundException) {
            return $this->errorResponse('The specified data cannot be found.', Response::HTTP_NOT_FOUND);
        }


        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected Exception. Try later');

    }

    /**
     * @param Request $request
     * @param AuthenticationException|AuthenticationException $exception
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse|RedirectResponse|Response
    {

        if($request->expectsJson() || $request->headers->has('Authorization')){
            return $this->errorResponse('Unauthorized.', Response::HTTP_UNAUTHORIZED);
        }

        return redirect()->guest('login');
    }
}
