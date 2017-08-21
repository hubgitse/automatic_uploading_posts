<?php

use App\lib\Registry;
/**
 * Autoloader
 */
require_once(__DIR__."/../autoloader.php");

$config = require_once(__DIR__."/config/params.php");

$db = $config['database'];

$connection = new PDO(
    sprintf("mysql:dbname=%s;host=%s",$db["database_name"],$db["server_name"]),
    $db['user_name'],
    $db['password']
);

Registry::setServiceOrParam('pdo', $connection);

Registry::setServiceOrParam('path', $config['path_to_posts']);

Registry::setServiceOrParam('articles_count', $config['articles_count']);

Registry::setServiceOrParam('table', $config['table']);

Registry::readOnly();