<?php
declare(strict_types=1);

namespace Controllers;

use Core\Response;
use Repository\ImagesRepository;

class MainController extends AbstractController
{

    public function index()
    {
        $this->repository = new ImagesRepository();
        $pagingSize = 28;

        $imagesArray = $this->repository->downloadAllImages();
        //if there are no images return empty
        if ($imagesArray == false) {
            $this->view('index', new Response(200, ["imageData" => [], "pageInfo" => 1]));
            return;
        }

        $page = substr($this->data["parameters"], 6); //Get the number of page
        $maxPages = ceil(count($imagesArray) / $pagingSize); //Get the number of pages

        if (empty($page)) {
            $page = "1";
        }

        $helperArray = [];
        $firstImageToShow = ($page - 1) * $pagingSize;
        $lastImageToShow = $page * $pagingSize - 1;
        for ($i = $firstImageToShow; $i <= $lastImageToShow; $i++) {
            if (empty($imagesArray[$i])) {
                break;
            }
            if ($imagesArray[$i]["privacy"] == false) {
                array_push($helperArray, $imagesArray[$i]);
            } elseif (!empty($_SESSION["logged"]) && $_SESSION["logged"] == true && !empty($_SESSION["user"])) {
                $user = $_SESSION["user"];
                if ($user->getUsername() == $imagesArray[$i]["author"]) {
                    array_push($helperArray, $imagesArray[$i]);
                }
            }
        }
        $imagesArray = $helperArray;
        $pageInfo = ["page" => $page, "maxPages" => $maxPages];
        $this->view('index', new Response(200, ["imageData" => $imagesArray, "pageInfo" => $pageInfo]));
    }

    public function pageNotFound()
    {
        $this->view("Errors/pageNotFound", new Response(404, []));
    }
}