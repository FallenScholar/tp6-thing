<?php

namespace app\middleware;

use think\facade\Config;
use think\Response;
use think\Request;
use Closure;

/**
 * Class AccessMiddleware
 * 防跨站 中间件
 *
 * @author FallenScholar
 * @version
 * @date
 */
class AccessMiddleware
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = [
            'access-control-allow-headers'  =>  'Origin,No-Cache,X-Requested-With,If-Modified-Since,Pragma,Last-Modified,Cache-Control,Expires,Content-Type,Access-Control-Allow-Credentials,DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Token,X-Timestamp',
            'access-control-allow-methods'  =>  'GET,POST'
        ];
        $origin = $request->header('origin', '');

        // 获取提前配置的域名IP白名单
        $domain = Config::get('app.front_origins');
        $domain = explode(',', $domain);
        if( in_array($origin, $domain) ) $headers['access-control-allow-origin'] = $origin;

        /* @var $response Response */
        $response = $next($request);
        $response->header($headers);
        return $response;
    }
}
