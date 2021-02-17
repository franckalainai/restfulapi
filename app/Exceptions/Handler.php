<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {   if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if($exception instanceof ModelNotFoundException){
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse('Does not exists any ' .$modelName . ' with the specified ID', 404);
        }

        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request, $exception);
        }

        if($exception instanceof AuthorizationException){
            return $this->errorResponse($exception->getMessage(), 403);
        }

        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse('The specified URL cannot be found', 404);
        }

        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('The specified method for the request is invalid', 405);
        }

        if($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if($exception instanceof QueryException){
            $errorCode = $exception->errorInfo[1];
            if($errorCode == 1451){
                return $this->errorResponse('Cannot remove this resource pemanently. It is related to any other resource', 409);
            }
        }

        if($exception instanceof TokenMismatchException){
            return redirect()->back()->withInput($request->input());
        }

        if(config('app.debug')){
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected exception. Try later', 500);

    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Redirection vers la page de login apres tentative
        //d'aller sur une page pour les utilisateurs authentifié
        if($this->isFrontEnd($request)){
            return redirect()->guest('login');
        }
        return $this->errorResponse('Unauthenticated', 401);
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
        $errors = $e->validator->errors()->getMessages();

        // Message pour les champs de connexion
        if($this->isFrontEnd($request)){
            return $request->ajax() ? response()->json(422) : redirect()
            ->back()
            ->withInput($request->input())
            ->withErrors($errors);
        }

        return $this->errorResponse($errors, 422);
    }

    // Fonction pour envoyer les message d'erreur en format web via l'interface de login
    private function isFrontEnd($request){
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
