<?php

namespace App\UserModule\UI\Controllers;


use TestFramework\Components\HttpComponents\JsonResponse;
use TestFramework\Components\HttpComponents\Request;
use TestFramework\Components\Controller\FrameworkController;

class UserController extends FrameworkController
{
    public function index()//: string
    {
         echo JsonResponse::create()->json(["value" => "UserController::index()"], 200);
    }

    /**
     * @param string $word
     * @param string $number
     */
    public function test(string $word, int $number)//: string
    {
        echo JsonResponse::create()->json(['$word' => $word, '$number' => $number], 200);
        //echo JsonResponse::create()->json(["value" => "UserController::index()"], 200);
    }
}