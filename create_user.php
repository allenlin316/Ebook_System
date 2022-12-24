<?php
session_start();
include "db_conn.php";

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE user_name=$username AND password=$password";
$result = mysqli_query($conn, $sql);
$rowcount=mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

if($row > 0){
    header("Location: register.php?error=帳密已經存在");
}
else{
    $sql = "INSERT INTO users (user_name, password) 
    VALUES ('" . $username "', '" . $password .  "')";
    mysqli_query($conn, $sql);
    header("Location: register.php?msg=成功註冊");
}

?>
