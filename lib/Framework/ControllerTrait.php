<?php
namespace Framework;

use Symfony\Component\HttpFoundation\Response;

trait ControllerTrait {
    protected static $blade;

    public static function setTemplateEngine($engine) {
        self::$blade = $engine;
    }

    public static function renderTemplate(string $view, array $data = []) : Response {
        return new Response(self::$blade->render($view, $data));
    }
}
