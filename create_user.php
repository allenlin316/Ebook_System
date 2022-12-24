<?php
session_start();
include "db_conn.php";

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE user_name='{$username}' AND password='{$password}'";
$result = mysqli_query($conn, $sql);


if(mysqli_num_rows($result)){
    header("Location: register.php?error=帳密已經存在");
}
else{
    $sql = "INSERT INTO users (user_name, password) 
    VALUES ('{$username}', '{$password}')";
    mysqli_query($conn, $sql);
    header("Location: register.php?error=成功註冊");
}

?>
