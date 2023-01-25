# PHPFrame

## Docs
### Routen registrieren

Um eine neue Route zu registrieren bearbeite `Routes/routes.php` und füge die benötigte route hinzu
#### Typen
##### GET
```php
Router::get('/neue/Route', 'ControllerFuerRoute@FunktionInController')
```
##### Post
```php
Router::post(...)
```
##### PUT/PATCH
```php
Router::put(...)
Router::patch(...)
```
##### DELETER
```php
Router::delete(...)
```
#### Routen bennenen
```php
Router::get(...)->name("NameDerRoute")
```
#### Routen mit paramtern
```php
Router::get('/notes/show/{id}', 'ControllerFuerRoute@FunktionMitParameter');
```

### Controllers
Um einen neuen Controller zu erstellen erstelle eine neue datei in `App/Controllers` oder in einem Unterordner
```php
<?php

namespace App\Controllers;

class ControllerFuerRoute {

    function FunktionInController($request) {
        Response::view('notes.about', ["name" => "john"]);
    }

    function FunktionMitParameter($request, $id) {
        $arr = ["name"=>"john", "age"=>12]
        Response::json($arr, 200);
    }

}
```

### Responses
In PHPFrame gibt es verschiedene arten daten auszugeben
#### Views
Alle view Dateien befinden sich in dem Ordner `Views` oder in einem der Unterordner
```php
Response::view('unterordner.viewDateiNameOhneEndung');
```
View Dateien werden in folgendem Format benannt: `<Name>.view.php`
#### JSON
Um daten als JSON auszugeben kann man die funktion `json()` benutzen:
```php
Response::json($daten)
```
#### Redirect
Um einen Redirect durchzuführen kann man die funktion `redirect()` verwenden:
```php
Response::redirect($path,$before,$after)
```
Wobei `before` ein funktio ist
#### Raw daten
um raw daten auszugeben kann man die funktion `response()` verwenden:
```php
Response::response($daten)
```
### Datenbank
Um die datenbank zu konfigurieren bearbeite die `config.php` Datei

Für sqlite:
```php
<?php

use function Core\base_path;

return $config = [
    "db" => [
        "connection" => "sqlite",
        "name" => base_path('Database/database.sqlite'),
    ],
    "debug" => "false",
    "url" => "http://localhost:8000"
    ];
```


Für mysql
```php
<?php


return $config = [
    "db" => [
        "connection" => "mysql",
        "host" => "localhost:3306"
        "name" => "DatenbankName",
        "username" => "username",
        "password" => "password"
    ],
    "debug" => "false",
    "url" => "http://localhost:8000"
    ];
```

#### queries

Um eine Datenbank anfrage zu tätigen füre `$db = App::resolve('Core\Database\Database')`
```php
$stmt = $db->query("Select * from table where id=:id and name=':name'", ["id" => $id, "name" => $name]); # PDOStatement
```
Diese funktion gibt ein `PDOStatement` zurück. Das heißt alle funktionen die [hier](https://www.php.net/manual/en/class.pdostatement.php) genannt werden sind verfügbar.

#### View templates

Alle Variablen die vom controller durch die funktion `Response::view()` übergeben wurden sind hier verfügbar.

Verfügbare funktionen

```php
out($name)
```
Gibt String aus. Wird vorher escaped.

```php
outNoEscape($name)
```
Gibt String aus. Wird vorher nicht escaped

```php
asset("styles.css") 
```
gibt tag (`<link>`, `<script>`, ...) zurück für die datei. Alle asset dateien befinden sich in `/public/assets/`

Diese funktion funktioniert nur für lokale dateien, stylesheets oder scripts aus dem Internet müssen manuell hinzugefügt werden.

```php
url("pfad/zu/route") // // http://localhost:8080/pfad/zu/route
```
Benutzt die in `config.php` definierte url und hängt gegebenen pfad an


```php
routePath($name)
```
gibt pfad zurück für eine benannte route.

```php
route($name, ["id" => 4])
```
gibt pfad zurück für eine benannte route und ersetzt parameter in route durch gegebene werte.

Jede funktion muss importiert werden
```php
use function Core/out;
use function Core/outNoEscape;
use function Core/asset;
use function Core/url;
use function Core/routePath;
use function Core/route;
```


