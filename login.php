<?php
session_start();
include "db_conn.php";

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE user_name='$username' AND password='$password'";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
if($row["user_name"]==$username && $row["password"]==$password){
    echo "Logged in!";
    $_SESSION["user_name"] = $row["user_name"];
    $_SESSION["id"] = $row["id"];
    header("Location: home.php");
    exit();
}
else{
    header("Location: index.php?error=Incorrect User name or Password");
    exit();
}
?>
