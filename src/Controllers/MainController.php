<?php
declare(strict_types=1);

namespace Controllers;

class MainController extends AbstractController
{

    public function index()
    {
        $this->view('index');
    }

    public function pageNotFound()
    {
        $this->view("Errors/pageNotFound");
    }
}