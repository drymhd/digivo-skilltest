<?php

namespace Core;

class View
{
    public static function render($view, $data = [])
    {
        extract($data);
        ob_start();
        require __DIR__ . "/../app/Views/$view.php";
        $content = ob_get_clean();
        require __DIR__ . '/../app/Views/layout.php';
    }
}