<?php
include "db_conn.php";

$user_id =  $_POST["user_id"];
$book_id = $_POST["book_id"];

if(isset($_POST["unlike_book"])){ // 取消收藏
    echo "remove book from collections";
    $sql = "DELETE FROM `user_book` WHERE user_id='" . $user_id . "' AND book_id='" . $book_id . "'";
    header("Location: collections.php");
}
else{   // 加入收藏
    echo "add book to collections";   
    $sql = "INSERT INTO `user_book`(`id`, `user_id`, `book_id`) VALUES (NULL, '" . $user_id . "','" . $book_id . "')";
    header("Location: home.php");
}

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} 
else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



?>