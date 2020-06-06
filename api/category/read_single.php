<?php

namespace PHP_REST_API;

use PDO;

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/DataBase.php';
include_once '../../models/Category.php';

// Instantiate Database and Connect
$database = new Database();
$db = $database->connect();

// Make an instance of a Category Object
$category = new Category($db);

// Get id from url
$category->id = $_GET['id'] ?? die();

// Get Category
$category->readSingle();

// Create Array
$categoryArr = array(
    'id' => $category->id,
    'name' => $category->name,
    'created_at' => $category->created_at,
);

print_r(json_encode($categoryArr));
