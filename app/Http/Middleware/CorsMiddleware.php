<?php namespace App\Http\Middleware;

class CorsMiddleware {

  /**
   * Handles the incoming request and adds the necessary CORS headers to the response.
   *
   * @param mixed $request The incoming request.
   * @param \Closure $next The next middleware in the chain.
   * @return \Illuminate\Http\Response The response with the added CORS headers.
   */
  public function handle($request, \Closure $next)
  {
    $response = $next($request);
    $response->header('Access-Control-Allow-Origin', '*');
    $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
    $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
    

    return $response;
  }

}