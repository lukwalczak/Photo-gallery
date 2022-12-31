<?php
declare(strict_types=1);

namespace Controllers;

use Repository\ImagesRepository;

class MainController extends AbstractController
{

    public function index()
    {
        $this->repository = new ImagesRepository();
        $pagingSize = 28;
        $imagesArray = $this->repository->downloadAllImages();
        $page = substr($this->data["parameters"], 6);
        if (empty($page)) {
            $page = 1;
        }
        $helperArray = [];
        $firstImageToShow = ($page - 1) * 28;
        $lastImageToShow = $page * 28 - 1;
        for ($i = $firstImageToShow; $i <= $lastImageToShow; $i++) {
            if (empty($imagesArray[$i])) {
                break;
            }
            array_push($helperArray, $imagesArray[$i]);
        }
        $imagesArray = $helperArray;
        $this->view('index', ["imageData" => $imagesArray, "currentPage" => $page]);
    }

    public function pageNotFound()
    {
        $this->view("Errors/pageNotFound");
    }
}