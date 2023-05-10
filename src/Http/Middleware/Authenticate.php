<?php

namespace Lugmety\Auth\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\UnauthorizedException;
use Lugmety\Auth\Services\Singleton\AuthUser;
use Lugmety\Auth\Services\Singleton\AppHeader;
use Lugmety\Auth\Traits\APIResponse;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    use APIResponse;

    private AuthUser $authUser;
    private AppHeader $appHeader;

    public function __construct(AuthUser $authUser, AppHeader $appHeader)
    {
        $this->authUser = $authUser;
        $this->appHeader = $appHeader;
    }

    public function handle(Request $request, Closure $next, $permission = ""): Response
    {
        try {

            $redis = Redis::connection(config("lugmety_auth.redis.connection"));
            
            /**
             * Bearer token
             * */
            if($request->has("access_token") && !isset($request->header()["authorization"])){

                $accessToken = "Bearer $request->access_token";
            }
            else{
                $accessToken = isset($request->header()["authorization"]) ? $request->header()["authorization"][0] : null;

                if(!$accessToken){
                    throw new UnauthorizedException("Authorization header parameter is required");
                }
            }

            /*
             * explode into array 0=> Bearer
             * 1=>token
             * */
            $explodeToken = explode(" ",$accessToken);
            if(!isset($explodeToken[1])){
               $explodeToken[1]= "";
            }

            $authKey = "#auth:{$explodeToken[1]}";
            
            if($redis->exists($authKey)){
                $decoded_result = unserialize($redis->get($authKey));
            } else {
                $headers = [
                    "Authorization" => $accessToken,
                    "Accept" => "application/json",
                ];

                if(isset($request->header()["version"])){
                    $headers["version"] = $request->header()["version"][0];
                }

                // get the oauth introspect url from config
                $oauth_url = config("lugmety_auth.services.introspect_url");
                
                // get the result form auth service
                $result = Http::withHeaders($headers)->post($oauth_url, [
                    "token" => $explodeToken[1],
                    "permission" => $permission
                ])->throw();

                // decode the result
                $decoded_result = json_decode($result->getBody(), true);
            }

            // pass the token to header service
            $this->appHeader->setToken( $accessToken );

            // add user data to the app instance
            $this->authUser->setUser($decoded_result);

            //add token to the app instance
            $this->authUser->setToken($explodeToken[1]);

            return $next($request);

        } catch (UnauthorizedException $exception) {
            return $this->errorResponse($exception->getMessage(), [], 403);
        } catch (RequestException $exception) {
            return $this->errorResponse(
                $exception->getMessage(),
                [],
                (int) $exception->getCode()
            );
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }
}
