<?php

// This is the database connection configuration.
return array(
    'connectionString' => 'mysql:host=localhost;dbname=skyeng',
    'emulatePrepare' => true,
    'schemaCachingDuration' => true,
    'username' => 'skyeng',
    'password' => 'skyeng',
    'tablePrefix' => 'sky_',
    'nullConversion' => PDO::NULL_EMPTY_STRING,
    'charset' => 'utf8',
);