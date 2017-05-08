<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($e instanceof TokenMismatchException){
			echo json_encode(['status'=>true, 'msg'=>'TokenMismatchException:'.$e->getMessage()]);exit;
		}
		
		if ($e instanceof MethodNotAllowedHttpException){
			echo json_encode(['status'=>true, 'msg'=>'MethodNotAllowedHttpException:'.$e->getMessage()]);exit;
		}
		
		if ($e instanceof Exception){
			echo json_encode(['status'=>true, 'msg'=>'Exception:'.$e->getMessage().' in file '.$e->getFile().' on line no '.$e->getLine()]);exit;
		}
		
		return parent::render($request, $e);
	}

}
