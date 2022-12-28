<?php

namespace Controllers;

abstract class AbstractController
{
    private $params;

    public function __construct($passedParameters = [])
    {
        $this->params = $passedParameters;
    }
}