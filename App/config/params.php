<?php

/**
 * Returning config options (path to posts, max posts to load into database, database connection data, db table name)
 */
return [
    'path_to_posts' => $_SERVER['DOCUMENT_ROOT'].'/posts',
    'articles_count' => 1,
    'database' => [
        'server_name' => 'localhost',
        'database_name' => 'testloader',
        'user_name' => 'root',
        'password' => '',
    ],
    'table' => 'wp_posts'
];