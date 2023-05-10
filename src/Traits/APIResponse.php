<?php

namespace Lugmety\Auth\Traits;

trait APIResponse
{

    /**
     * @param string $message
     * @param array $data
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message = '', array $data=[], int $status_code = 500 ) {

        $payload['status'] = 'error';

        if($message)
            $payload['message'] = $message;

        if($data)
            $payload['payload'] = $data;

        return response()->json($payload, $status_code );
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse(string $message = '',  $data = [], int $status_code = 200 ) {

        $payload['status'] = 'success';

        if($message)
            $payload['message'] = $message;

        if($data)
            $payload['payload'] = $data;

        return response()->json($payload, $status_code );
    }

}
