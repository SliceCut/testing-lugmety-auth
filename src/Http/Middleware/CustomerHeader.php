<?php

namespace Lugmety\Auth\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Lugmety\Auth\Services\Singleton\AppHeader;
use Lugmety\Auth\Traits\APIResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomerHeader
{
    use APIResponse;

    private AppHeader $appHeader;

    public function __construct(AppHeader $appHeader)
    {
        $this->appHeader = $appHeader;
    }

    public function handle(Request $request, Closure $next): Response
    {
        try{

            $required_headers = [ 'x-device', 'x-device-os', 'x-device-os-version', 'x-app-version'];

            $error_header = [];

            foreach ($required_headers as $header){

                if(!$request->hasHeader($header) || $request->header($header) == '' ){
                    $error_header[$header] =[
                        "$header header parameter is required"
                    ];
                }
            }

            if(count($error_header)){
                throw ValidationException::withMessages($error_header);
            }

            $lang = $request->header('x-lang', 'en');

            app()->setLocale($lang);

            $this->appHeader->setLang($request->header('x-lang', 'en'));

            $this->appHeader->setAppVersion($request->header('x-app-version'));

            $this->appHeader->setDevice($request->header('x-device'));

            $this->appHeader->setDeviceOs($request->header('x-device-os'));

            $this->appHeader->setDevicesOsVersion($request->header('x-device-os-version'));

            return $next($request);
        }catch (ValidationException $exception){
            return $this->errorResponse('Header Required', $exception->errors(), 422);
        } catch(Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }
}
