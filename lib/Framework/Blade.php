<?php
namespace Framework;

use Symfony\Component\HttpFoundation\Response;
use Jenssegers;

class Blade {
    private static $blade;

    public static function init() {
        $cacheFolder = __DIR__."/../../cache/blade";
        if (file_exists($cacheFolder) === false) {
            mkdir($cacheFolder, recursive: true);
        }

        self::$blade = new Jenssegers\Blade\Blade(__DIR__."/../../app/views", $cacheFolder);
    }
    
    public static function make(string $view, array $data = []) : string {
        return self::$blade->render($view, $data);
    }

    public static function render(string $view, array $data = []) : Response {
        return new Response(self::make($view, $data));
    }
}