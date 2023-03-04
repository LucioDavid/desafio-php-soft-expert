<?php

namespace Src\Core\Http;

use Src\Core\Template;

class Controller
{
    protected Template $template;

    public function __construct()
    {
        $this->template = new Template();
    }
}