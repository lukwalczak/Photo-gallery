<?php

namespace Controllers;

abstract class AbstractController
{
    protected $params = [];

    public function __construct($passedParameters = [])
    {
        $this->params = $passedParameters;
    }
}