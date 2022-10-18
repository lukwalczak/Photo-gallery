<?php

declare(strict_types=1);

namespace Core;

class Router
{

    private $routeTable = [];

    private $parameters;

    private static $instances = [];

    protected const urlRegex = "/^(?P<controller>$|\s+|[-a-z]+)?[\\/]*(?P<action>[-a-z]+)?[\\/]*(?P<parameters>.*)$/";

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

    /**
     * @param mixed $routeTable
     */
    public function setRouteTable(): void
    {
        $routeTableConfig = dirname(dirname(__DIR__)) . '/config/routeTable.yaml';
        $parsedRoutes = yaml_parse_file($routeTableConfig);
        $this->routeTable = $parsedRoutes;
    }

    /**
     * @return mixed
     */
    public function getRouteTable(): array
    {
        return $this->routeTable;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getCurrentPath(): string
    {
        if ($this->getParameters()[0] == "") {
            return "/";
        }
        return $this->getParameters()[0];
    }

    public function matchURL($targetRoute): bool
    {
        if (preg_match(self::urlRegex, $targetRoute, $output)) {
            foreach ($this->getRouteTable() as $route) {
                if (empty($output['controller']) || $route['path'] == $output['controller']) {
                    $output["controller"] = $route["controller"];
                    $this->setParameters($output);
                    if ($this->parameters["action"] == "") {
                        $this->parameters["action"] = "default";
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public function dispatch($url)
    {
        if ($this->matchURL($url)) {
            $controller = $this->parameters["controller"];
            $controller = "Controllers\\$controller";
            if (class_exists($controller) && is_callable([$controller, $this->parameters["action"]])) {
                $action = $this->parameters["action"];
                $controller_obj = new $controller;
                $controller_obj->$action();
            } else
                echo "nie odnaleziono strony";
        } else
            echo "nie odnalzeiono strony";
    }
}