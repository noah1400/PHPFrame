<?php

namespace Routes;

use Core\Router;

require 'errors.php';

Router::get('/', 'FirstController@index');
Router::get('/about', 'FirstController@about');
Router::get('/new/route/{id}', 'FirstController@newRoute')->name('newRoute');
