<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //https://stackoverflow.com/questions/29479409/redirect-to-homepage-if-route-doesnt-exist-in-laravel-5
        if($this->isHttpException($exception) !== true)
            return parent::render($request, $exception);

        switch ($exception->getStatusCode()) 
        {
            // not found
            case 404:
            return redirect()->guest('login');
            break;

            // internal error
            case '500':
            return redirect()->guest('login');
            break;

            default:
                return parent::render($request, $exception);
            break;
        }

        //return parent::render($request, $exception);
    }
}
