<?php
namespace Framework;

use Closure;

class RouteInfo {
    public function __construct(
        public string|Closure $controller,
        public bool $callback = false,
        public bool $authRequired = false
    ) {}
}