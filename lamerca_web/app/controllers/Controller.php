<?php

declare(strict_types=1);

class Controller
{
    protected function render(string $view, array $params = []): string
    {
        extract($params, EXTR_SKIP);

        $viewFile = VIEW_PATH . '/' . str_replace('.', '/', $view) . '.php';

        if (!is_file($viewFile)) {
            throw new RuntimeException("La vista '{$view}' no existe.");
        }

        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        ob_start();
        include VIEW_PATH . '/layouts/main.php';
        return ob_get_clean();
    }
}
