<?php
declare(strict_types=1);

namespace Controllers;

use Core\Response as Response;

abstract class AbstractController
{
    protected $response;

    protected $repository;

    protected $data;

    public function __construct($data, $repository = "")
    {
        $this->repository = $repository;
        $this->data = $data;
        $this->response = new Response();
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response): void
    {
        $this->response = $response;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function model($model)
    {
        require_once dirname(__DIR__) . "/Models/" . $model . ".php";
        $model = "Models\\$model";
        $modelObj = new $model();
        return $modelObj;
    }

    public function view($view, $response)
    {
        require_once dirname(__DIR__) . "/Views/" . $view . "View.php";
    }

}