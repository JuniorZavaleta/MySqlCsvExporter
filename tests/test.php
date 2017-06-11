<?php

require __DIR__."/../vendor/autoload.php";

use Csv\CsvGenerator;

$credenciales = [
    'host' => 'localhost',
    'dbname' => 'test',
    'username' => 'root',
    'password' => '',
];

$csv = new CsvGenerator("test_table", $credenciales);

$csv->execute();
