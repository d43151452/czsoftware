<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CrossHttp
{
    private $headers;
    private $allow_origin;

    public function handle($request, Closure $next)
    {
        $this->headers = [
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE,OPTIONS',
            'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers'),
            'Access-Control-Allow-Credentials' => 'true',//允许客户端发送cookie
            'Access-Control-Max-Age' => 1728000 
        ];

        // 把要接受跨域请求的域名放这里
        $this->allow_origin = [
            'http://abc.com', 
        ];

        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        if (!in_array($origin, $this->allow_origin) && !empty($origin))
            return new Response('Forbidden', 403);
        if ($request->isMethod('options'))
            return $this->setCorsHeaders(new Response('OK', 200), $origin);
        $response =  $next($request);
        $methodVariable = array($response, 'header');

        if (is_callable($methodVariable, false, $callable_name)) {
            return $this->setCorsHeaders($response, $origin);
        }
        return $response;
    }
   
    public function setCorsHeaders($response, $origin)
    {
        foreach ($this->headers as $key => $value) {
            $response->header($key, $value);
        }
        if (in_array($origin, $this->allow_origin)) {
            $response->header('Access-Control-Allow-Origin', $origin);
        } else {
            $response->header('Access-Control-Allow-Origin', '');
        }
        return $response;
    }
}