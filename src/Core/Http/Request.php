<?php

namespace Src\Core\Http;

class Request
{
    public array $params = [];

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, offset: 0, length: $position);
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody(): array
    {
        $body = [];
        if ($this->method() === 'get') {
            $body = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if ($this->method() === 'post') {
            $body = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $body;
    }

    public function setParams(array $values)
    {
        foreach ($values as $value) {
            $this->params[] = $value;
        }
    }
}
