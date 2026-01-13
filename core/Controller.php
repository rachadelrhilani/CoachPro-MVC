<?php
namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(dirname(__DIR__) . '/app/Views');
        $this->twig = new Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);

        $this->twig->addGlobal('session', $_SESSION ?? []);
        $this->twig->addGlobal('base_url', BASE_URL);
    }

    protected function render(string $view, array $data = [])
    {
        echo $this->twig->render($view . '.twig', $data);
    }

    protected function redirect(string $path)
    {
        header("Location: " . BASE_URL . $path);
        exit;
    }
}

