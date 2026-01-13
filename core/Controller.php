<?php
namespace Core;

abstract class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);
        require "../app/Views/$view.php";
    }

    protected function redirect($path)
    {
        header("Location: $path");
        exit;
    }
}
