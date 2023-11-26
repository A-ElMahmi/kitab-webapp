<?php
namespace Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Yaml\Yaml;


class StaticController {
    public static function main(Request $request) : Response {
        $allowed_static_types = Yaml::parseFile(__DIR__."/allowed_static_types.yaml");

        $path = $request->getPathInfo();
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        $response = match ($allowed_static_types[$extension][1]) {
            "FILE" => new BinaryFileResponse(file: __DIR__ . "/../../public/$path", headers: ["Content-Disposition" => "inline"]),
            "TEXT" => new Response(file_get_contents(__DIR__ . "/../../public/$path")),
        };

        $response->headers->set("Content-Type", $allowed_static_types[$extension][0]);
        return $response;
    }
}
