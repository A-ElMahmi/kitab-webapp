<?php
namespace Simplex;

use Symfony\Component\Routing;
use Symfony\Component\Yaml\Yaml;


class StaticRoutes {
    private static $routes;
    private static $allowedStaticTypes;

    public static function generate() : Routing\RouteCollection {
        self::$routes = new Routing\RouteCollection();
        self::$allowedStaticTypes = Yaml::parseFile(__DIR__."/allowed-static-types.yaml");

        self::searchFolder("/");
        
        return self::$routes;
    }
    
    private static function searchFolder(string $relativeFolderPath) {
        $contents = self::getFolderContents($relativeFolderPath);
        
        foreach ($contents as $item) {
            $fullPath = __DIR__ . "/../../public/$relativeFolderPath/$item"; 

            if (is_dir($fullPath)) {
                self::searchFolder($relativeFolderPath . $item);

            } else if (is_file($fullPath)) {
                self::addFile($relativeFolderPath, $item);
            }
        }
    }
    
    private static function addFile(string $relativeFolderPath, string $fileName) {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (isset(self::$allowedStaticTypes[$extension]) === false) return;
        
        self::$routes->add("static-" . $fileName, new Routing\Route(
            path: "$relativeFolderPath/$fileName",
            defaults: ["_controller" => "Simplex\\StaticController::main"],
            methods: "GET",
        ));
    }

    private static function getFolderContents(string $folder) : array {
        return array_diff(scandir(__DIR__ . "/../../public/$folder"), [".", ".."]);
    }
}