<?php

namespace Src\Core;

use Src\Core\Router;
use Src\Core\Session;
use Src\Core\Template;
use Src\Core\Database\DBDriver;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public static DBDriver $db;

    public Router $router;
    public Template $template;

    public function __construct(string $rootPath)
    {
        date_default_timezone_set('America/Sao_Paulo');
        Session::start();
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        self::$db = new DBDriver();
        $this->router = new Router();
        $this->template = new Template();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
