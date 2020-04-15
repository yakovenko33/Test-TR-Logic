<?php


namespace TestFramework\Components\Kernel;


//use http\Env\Response;
use TestFramework\Components\HttpComponents\Request;
use TestFramework\Components\Controller\FrameworkController;

final class Router
{
    /**
     * @var array
     */
    private $routes;

    /**
     * @var string
     */
    private $requestUri;

    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var string
     */
    private $actionName;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        //D:\Program Files\OSPanel\domains\test_project\routes\routes.php
        //$routesPath = ROOT . '/routes/routes.php';
        //require_once(ROOT . '/routes/routes.php');
        $this->routes = require_once(ROOT . '/routes/routes.php');
        $this->requestUri = $_SERVER['REQUEST_METHOD'] . trim($_SERVER["REQUEST_URI"]); //maybe empty?
    }

    public function run(): void
    {
        $includeController = false;
        foreach($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $this->requestUri)) {

                $fullPath = preg_replace("~$uriPattern~", $path, $this->requestUri);
                $segments = explode('@', $fullPath);
                $this->controllerName = array_shift($segments);
                $this->actionName = array_shift($segments);
                $includeController = $this->includeController(new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER), $segments);
                var_dump($includeController);

//                echo "<pre>";
//                $segments = explode('@', $fullPath);
//                $this->controllerName = array_shift($segments);
//                $this->actionName = array_shift($segments);
//                //$this->includeController($segments);
//                var_dump($fullPath);
//                var_dump($this->controllerName);
//                var_dump($this->actionName);
//                var_dump($segments);
//                die;
            }
        }

        if (!$includeController) {
            var_dump("404");
        }
    }

    /**
     * @param Request $request
     * @param array $params
     * @return bool
     * @throws \ReflectionException
     */
    private function includeController(Request $request, array $params = []): bool
    {
        if (class_exists($this->controllerName)) {
            $controller = new $this->controllerName();
            if (method_exists($controller, $this->actionName)) {
                $action = $this->actionName;
                !empty($params) ? $this->initActionWithParams($controller, $params) : $controller->$action($request); //$controller->$action($params)

                return true;
            }
        }

        return false;
    }

    /**
     * @param FrameworkController $controller
     * @param array $params
     * @throws \ReflectionException
     */
    private function initActionWithParams(FrameworkController $controller, array $params)
    {
        $reflectionMethod = new \ReflectionMethod($this->controllerName, $this->actionName);
        $reflectionMethod->invokeArgs($controller, $params);
    }

    private function reflection(): void
    {
        $reflection = new \ReflectionClass(Employee::class);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($employee, new Id(25));
    }
}