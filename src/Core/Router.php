<?php

declare(strict_types=1);

namespace Core;

use Controllers\MainController;

class Router
{

    private $routeTable = [];

    private $parameters;

    private static $instances = [];

//    private const urlRegex = "/^(?P<controller>$|\s+|[-a-z]+)?[\\/]*(?P<action>[-a-z]+)?[\\/]*(?P<parameters>.*)$/";

    public function __construct()
    {
    }

    public function __clone()
    {
    }

    public function __wakeup()
    {
    }

    public static function getInstance(): Router
    {
        $cls = static::class;
        if (isset(self::$instances)) {
            self::$instances[$cls] = new static();
        }
        self::$instances[$cls]->setRouteTable();
        return self::$instances[$cls];
    }

    public function setRouteTable(): void
    {
        $routeTableConfig = dirname(__DIR__, 2) . "/config/routeTable.yaml";
        $parsedRoutes = yaml_parse_file($routeTableConfig);
        $this->routeTable = $parsedRoutes;
    }

    public function getRouteTable(): array
    {
        return $this->routeTable;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function matchURL(string $targetRoute): bool
    {
        foreach ($this->getRouteTable() as $route) {
            if (preg_match($route["path"] . "i", $targetRoute, $output)) {
                $output["controller"] = $route["controller"];
                $output["repository"] = $route["repository"];
                $this->setParameters($output);
                if (empty($this->parameters["action"]) || $this->parameters["action"] == "") {
                    $this->parameters["action"] = "index";
                }
                return true;
            }
        }
        return false;
    }

    public function dispatch(string $url): void
    {
        if (!$this->matchURL($url)) {
            $this->pageNotFoundDispatch();
            return;
        }
        $controller = $this->parameters["controller"];
        $controller = "Controllers\\$controller";
        if (!(class_exists($controller) && is_callable([$controller, $this->parameters["action"]]))) {
            $this->pageNotFoundDispatch();
            return;
        }
        $repository = $this->parameters["repository"];
        $repository = "Repository\\$repository";
        if (!(class_exists($repository))) {
            $repositoryObj = "";
        } else {
            $repositoryObj = new $repository();
        }
        $action = $this->parameters["action"];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $controllerObj = new $controller($_GET, $repositoryObj);
            $controllerObj->$action();
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controllerObj = new $controller($_POST, $repositoryObj);
            $controllerObj->$action();
        }


    }

    public function pageNotFoundDispatch(): void
    {
        $controller = new MainController([]);
        $controller->pageNotFound();
    }

    private function dropNumericKeys(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_int($key)) {
                unset($array[$key]);
            }
        }
        return $array;
    }
}

