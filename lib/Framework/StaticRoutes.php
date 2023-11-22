<?php
namespace Framework;

use Symfony\Component\Routing;
use Symfony\Component\Yaml\Yaml;


class StaticRoutes {
    private static $routes;
    private static $allowed_static_types;

    public static function generate() : Routing\RouteCollection {
        self::$routes = new Routing\RouteCollection();
        self::$allowed_static_types = Yaml::parseFile(__DIR__."/allowed_static_types.yaml");

        self::searchFolder("/");
        
        return self::$routes;
    }
    
    private static function searchFolder(string $relativeFolderPath) {
        $contents = self::getFolderContents($relativeFolderPath);
        
        foreach ($contents as $item) {
            if (is_dir(__DIR__ . "/../../public/" . $relativeFolderPath . $item)) {
                self::searchFolder($relativeFolderPath . $item);
            }
        }
        
        self::addFiles($relativeFolderPath);
    }
    
    private static function addFiles(string $relativeFolderPath) {
        $contents = self::getFolderContents($relativeFolderPath);
        
        foreach ($contents as $item) {
            if (is_file(__DIR__ . "/../../public/$relativeFolderPath/$item")) {
                $extension = pathinfo($item, PATHINFO_EXTENSION);
                if (isset(self::$allowed_static_types[$extension]) === false) {
                    continue;
                }
                
                self::$routes->add($item, new Routing\Route(
                    path: "$relativeFolderPath/$item",
                    defaults: ["_controller" => "Framework\\StaticController::main"],
                    methods: "GET",
                ));
            }
        }
    }
    
    private static function getFolderContents(string $folder) : array {
        return array_diff(scandir(__DIR__ . "/../../public/$folder"), [".", ".."]);
    }
}