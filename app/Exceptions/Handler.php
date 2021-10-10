<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function convertExceptionToResponse(Throwable $e)
    {
        $uuid = Str::uuid();

        Log::error([
            'Id'    => $uuid,
            'Error' => $e->getMessage(),
            'Stack Trace' => $e->getTraceAsString()
        ]);

        $response = [
            'status'    => false,
            'error'     => new \stdClass(),
            'message'   => "Something Went Wrong!. Report With This ID:".$uuid
        ];

        return response()->json($response, 500);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        $fields = $e->validator->errors()->getMessages();

        $response = [
            'status'    => false,
            'error'     => new \stdClass(),
            'message'   => ""
        ];

        foreach($fields as $key => $value) {
            if($key[0] === "&") {
                $response[ltrim($key,"&")] = $fields[$key][0];
            } else {
                $response['error']->$key = $fields[$key][0];
            }
        }

        return response()->json($response, 422);
    }
}
