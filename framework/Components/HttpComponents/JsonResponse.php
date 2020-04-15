<?php

namespace TestFramework\Components\HttpComponents;

class JsonResponse
{
    /**
     * @return JsonResponse
     */
    public static function create(): JsonResponse
    {
        return new static();
    }

//    public function badResponse()
//    {
//        header_remove();
//        header("Content-Type: document");
//        http_response_code(500);
//    }

    /**
     * @param $params
     * @param int $status
     * @return string
     */
    public function json($params, $status = 200): string
    {
        header_remove();
        header("Content-Type: application/json");

        $json = json_encode($params);
        if ($json === false) {
            $json = json_encode(["json_error" => json_last_error_msg()]);
            http_response_code(500);
        } else {
            http_response_code($status);
        }

        return $json;
    }
}