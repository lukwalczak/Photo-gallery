<?php
declare(strict_types=1);

namespace Controllers;

class ImagesController extends AbstractController
{

    private $viewPath = "Images/";
    private $targetDir;

    public function __construct($data = [], $repository = "")
    {
        parent::__construct($data, $repository);
        $this->targetDir = dirname(__DIR__, 2) . "/public/images";
    }

    public function upload()
    {
        if (empty($_FILES)) {
            $this->view($this->viewPath . 'upload');
        }
        
        var_dump($_FILES["image"]["name"]);
        $this->view($this->viewPath . 'upload');
    }
}