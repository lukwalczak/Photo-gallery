<?php
declare(strict_types=1);

namespace Controllers;
class MainController extends AbstractController
{
    public function default()
    {
        echo "default main action";
    }

    public function pageNotFound($url)
    {
        echo "page " . $url . " not found";
    }
}