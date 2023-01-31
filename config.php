<?php

use function Core\base_path;

return $config = [
    "app" => [
        "name" => "My App",
    ],
    "db" => [
        "connection" => "sqlite",
        "name" => base_path('Core/Database/database.sqlite'),
    ],
    "debug" => "false",
    "url" => "http://localhost:8080"
    ];