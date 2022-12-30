<?php
declare(strict_types=1);

namespace Controllers;

abstract class AbstractController
{
    public $data;

    protected $repository;

    public function __construct($data = [], $repository = "")
    {
        $this->data = $data;
        $this->repository = $repository;
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

    public function view($view, $data = [])
    {
        require_once dirname(__DIR__) . "/Views/" . $view . "View.php";
    }

}