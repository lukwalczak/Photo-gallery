<?php
declare(strict_types=1);

namespace Controllers;

use Core\View;

class ImagesController extends AbstractController
{

    private $viewPath = "Images/";

    public function index()
    {
        echo View::render($this->viewPath . "index", $this->getParams());
    }

    public function add()
    {
        $user = parent::model('User');
        $user->name = "aleks";
        $this->view($this->viewPath . 'add', ['name' => $user->name]);
    }
}