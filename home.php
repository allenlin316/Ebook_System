<?php
session_start();
include "db_conn.php";

if(isset($_SESSION["id"]) && isset($_SESSION["user_name"])){    
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./bootstrap-4.6.2-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./style/style.css">
        <title>Library</title>
    </head>
    <body>
        <!-- Modal for account info -->
        <div class="modal fade" id="account_icon" tabindex="-1" aria-labelledby="account_icon" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">                    
                    <h5 class="modal-title" id="account_icon">Welcome <?php echo $_SESSION["user_name"] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    你好，這裡是電子書系統
                </div>
                <div class="modal-footer">
                    <a href="./logout.php" class="btn btn-info">登出</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                    
                </div>
                </div>
            </div>
        </div> 
        <div class="jumbotron jumbotron-fluid">
            <button class="btn" data-toggle="modal" data-target="#account_icon"><img src="./images/account_icon.png" alt="account icon" class="rounded-circle bg-white position-absolute" style="width: 4%; left: 34px; top: 25px;"></button>
            <img src="./images/search_icon.png" alt="search icon" class="position-absolute" style="width: 6%; right: 100px; top: 21px;">  
            <img src="./images/heart_icon.png" alt="heart icon" class="position-absolute" style="width: 3%; right: 30px; top: 33px;">          
            <div class="container">
                <h1 class="display-1 text-center">EBOOK</h1>            
            </div>
        </div>       
        <div class="container-fluid">
            <div class="row justify-content-around">
                    <?php 
                    $sql = "SELECT * FROM books";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $num_of_rows = mysqli_num_rows($result);                    
                    for($i=0; $i<$num_of_rows; $i++){
                        echo "<div class=\"col-md-2 mb-3 card\" style=\"width: 180px; height: auto;\">
                        <img src=\"./images/{$row[$i]["title"]}.jpg\" style=\"width: 60%; height: 180px;\" class=\"card-img-top mx-auto\" alt=\"atomic_habit book\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title text-center\">{$row[$i]["title"]}</h5>                            
                        </div>
                        </div>";
                    }?>                                    
            </div>                
        </div>                
        <script src="./jquery-3.5.1.min.js"></script>
        <script src="./bootstrap-4.6.2-dist/js/bootstrap.bundle.min.js"></script>                
    </body>
    </html>

    <?php
}
else{
    header("Location: index.php");
    exit();
}
?>