<?php
declare(strict_types=1);

namespace Controllers;

class ImagesController extends AbstractController
{

    private $viewPath = "Images/";

    public function upload()
    {
        $this->view($this->viewPath . 'add');
    }
}