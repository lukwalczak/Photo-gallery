<?php
declare(strict_types=1);

namespace Controllers;
class MainController
{
    public function default()
    {
        echo "default main action";
    }

    public function pageNotFound()
    {
        echo "page not Found";
    }
}