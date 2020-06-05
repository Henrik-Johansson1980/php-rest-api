<?php

namespace PHP_REST_API;

use PDO;

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/DataBase.php';
include_once '../../models/Post.php';

// Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//Blog Post Query
$result = $post->read();
$num = $result->rowCount();

// Check if there are any posts

if ($num > 0) {
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,
        );

        // Push to data
        array_push($posts_arr['data'], $post_item);

        //Decode to JSON and output
        echo json_encode($posts_arr);
    }
} else {
    // No posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}
