
<?php

echo "PHP Version: " . PHP_VERSION . "<br>";

echo "MongoDB Extension: ";
var_dump(extension_loaded("mongodb"));

echo "<br>MongoDB Client Class: ";
var_dump(class_exists("MongoDB\\Client"));

echo "<br>Composer Autoload: ";

require_once __DIR__ . "/vendor/autoload.php";

var_dump(class_exists("MongoDB\\Client"));

try {
    $client = new MongoDB\Client("mongodb://127.0.0.1:27017");

    $client->selectDatabase("admin")->command(["ping" => 1]);

    echo "<br>MongoDB Connection Successful!";
} catch (Throwable $e) {
    echo "<br>Connection Error: " . $e->getMessage();
}
