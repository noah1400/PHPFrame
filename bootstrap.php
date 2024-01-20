<?php

use Core\Container;
use Core\App;

require '../vendor/autoload.php';
require '../Core/functions.php';

App::setContainer(new Container());

App::bind('Core\Database\Database', function () {
    return new Core\Database\Database();
});

App::bind('Core\Session', function () {
    return new Core\Session();
});

App::bind('Core\Validator', function () {
    return new Core\Validator();
});