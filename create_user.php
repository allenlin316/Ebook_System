<?php
session_start();
include "db_conn.php";

$username = $_POST["username"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "SELECT * FROM users WHERE user_name='" . $username . "'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)){ // exists data in database
    header("Location: register.php?error=帳密已經存在");
}
else{
    $sql = "INSERT INTO users (user_name, password) 
    VALUES ('{$username}', '{$password}')";
    mysqli_query($conn, $sql);
    header("Location: index.php?success=成功註冊");
}

?>
