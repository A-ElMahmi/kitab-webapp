<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Session\Session;

function esc(string $s) : string {
    return htmlspecialchars($s, ENT_QUOTES);
}

function renderTemplate(string $view, array $props) : Response {
    ob_start();
    // (function() {
        extract($props);
        require __DIR__."/../views/$view.php";
    // }) ();

    $layoutBlock = ob_get_clean();
    
    // Custom Components
    // ob_start();
    // include __DIR__."/../components/List.php";
    // $listContent = ob_get_clean();
    
    // $layoutBlock = str_replace('<List />', $listContent, $layoutBlock);
    
    ob_start();
    require __DIR__."/../views/layout.php";

    return new Response(ob_get_clean());
}

class HelloController {
    public static function GET(Request $request) : Response {
        return renderTemplate("hello", ["name" => $request->attributes->get("name")]);
    }

    public static function POST() : Response {
        return renderTemplate("hello", ["name" => "success", "layoutTitle" => "POST"]);
    }
}
