<?php

namespace Routes;

use Core\Router;

use function Core\dd;

Router::get('/', 'FirstController@index');
Router::get('/about', 'FirstController@about');
Router::get('/new/route/{id}', 'FirstController@newRoute')->name('newRoute');
