<?php
declare(strict_types=1);

namespace Controllers;

use Repository\ImagesRepository;

class MainController extends AbstractController
{

    public function index()
    {
        $this->repository = new ImagesRepository();
        $imagesArray = $this->repository->downloadAllImages();
        $this->view('index', $imagesArray);
    }

    public function pageNotFound()
    {
        $this->view("Errors/pageNotFound");
    }
}