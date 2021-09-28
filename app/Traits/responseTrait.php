<?php

namespace App\Traits;

trait responseTrait
{

    /**
     * @return response
     */
    public function response($data, $message="", $title="",$code = '200')
    {
        $response = [
            'status'    => true,
            'data'      => $data,
            'title'     => $title,
            'message'   => $message
        ];

        return response()->json($response, $code);
    }
}
