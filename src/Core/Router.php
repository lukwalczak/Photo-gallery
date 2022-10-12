<?php

class Router
{

 private $routeTable = [];

 private $parameters;

 protected const urlRegex = '/^$|\s+|([-a-z]+\/*)?([-a-z]+\/*)?(.*)?$/';
 protected const urlRegexs = "/^$|\s+|([-a-z]+\/*)([-a-z]+\/*)(.*)$/";

 public function __construct()
 {
     $this->routeTable = $this->setRouteTable();
 }

    /**
     * @param mixed $routeTable
     */
    public function setRouteTable(): array
    {
        $f = dirname(__DIR__) . '/config/routeTable.yaml';
        $t = yaml_parse_file($f);
        return  $t;
    }

    /**
     * @return mixed
     */
    public function getRouteTable()
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
    public function getParameters()
    {
        return $this->parameters;
    }

    public function getCurrentPath()
    {
    if ($this->getParameters()[0] == "")
    {
        return "/";
    }
    return $this->getParameters()[0];
    }

    public function matchURL($targetRoute)
    {
        if (preg_match(self::urlRegex, $targetRoute, $output))
        {
            echo '<pre>';
            var_dump($output);
            echo '</pre>';
            foreach ($this->getRouteTable() as $route)
            {
                if ($route['path'] == $output[0])
                {
                    $this->setParameters($output);
                    return true;
                }
            }
        }
        return false;
    }
}
