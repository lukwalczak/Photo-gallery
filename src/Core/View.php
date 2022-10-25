<?php

namespace Core;

use Controllers\MainController;

class View
{
    public static function render($viewName, array $parameters = [])
    {
        $layoutDir = dirname(__DIR__) . "/Views/";
        $viewLayout = $layoutDir . $viewName . "View.php";
        if (is_readable($viewLayout)) {
            ob_start();
            extract($parameters, EXTR_SKIP);
            require($viewLayout);
            return ob_get_clean();
        } else {
            MainController::pageNotFound($parameters);
        }
    }
}