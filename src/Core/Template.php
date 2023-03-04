<?php

namespace Src\Core;

use Src\Core\Application;
use Src\Core\Session;

class Template
{
    private $layout;
    private $messages;

    public function __construct(string|null $layout = null)
    {
        $this->layout = $layout ?? 'main';
    }

    public function render(string $view = '', array $data = [])
    {
        $this->messages = Session::getMessages();
        $layoutContent = $this->layoutContent();
        $viewContent = $this->viewContent($view, $data);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    private function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/{$this->layout}.php";
        return ob_get_clean();
    }

    private function viewContent(string $view, array $data = [])
    {
        extract($data);
        ob_start();
        include_once Application::$ROOT_DIR."/views/{$view}.php";
        return ob_get_clean();
    }

    private function showErrors(array $errors = null)
    {
        if (!isset($errors)) {
            return '';
        }

        $html = '';
        foreach ($errors as $error) {
            $html .= "<span class=\"helper-text\" data-error=\"{$error}\"></span>";
        }
        return $html;
    }
}
