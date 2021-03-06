<?php

namespace PHP_REST_API;

use PDO;

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); //phpcs:ignore

include_once '../../config/DataBase.php';
include_once '../../models/Category.php';

// Instantiate Database and Connect
$database = new Database();
$db = $database->connect();

// Make an instance of a Category Object
$category = new Category($db);

// Get the raw data
$data = json_decode(file_get_contents('php://input'));

$category->name = $data->name;

// Create New Category
if ($category->create()) {
    echo json_encode(
        array('message' => 'Category Created')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Created')
    );
}
