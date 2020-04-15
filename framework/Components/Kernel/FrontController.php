<?php

namespace TestFramework\Components\Kernel;


use TestFramework\Components\Kernel\Router;
use TestFramework\Components\HttpComponents\Request;

final class FrontController
{
    //$_REQUEST
    public function start(): void
    {
//        echo "</pre>";
//        var_dump("FrontController::start()");
//        die;
        $this->initError();
        $router = new Router();
        $router->run();
    }

    private function initError(): void
    {
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
    }
}