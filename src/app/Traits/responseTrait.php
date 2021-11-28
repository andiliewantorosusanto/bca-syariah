<?php

namespace App\Traits;

trait responseTrait
{

    /**
     * @return response
     */
    public function response($data, $message="",$code = '200')
    {
        $response = [
            'status'    => true,
            'data'      => $data,
            'message'   => $message
        ];

        return response()->json($response, $code);
    }
}
