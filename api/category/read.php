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

// Query Categories.
$result = $category->read();

//Get number of returned rows.
$numRows = $result->rowCount();

//Check if there are any categories.
if ($numRows > 0) {
    $categoriesArr = array();
    $categoriesArr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $categoryItem = array(
            'id' => $id,
            'name' => $name,
            'created_at' => $created_at,
        );

        // Push to the categories data array
        array_push($categoriesArr['data'], $categoryItem);
    }
    // Echo the JSON decoded array.
    echo json_encode($categoriesArr);
} else {
        // No Categories
        echo json_encode(
            array('message' => 'No Categories Found.')
        );
}
