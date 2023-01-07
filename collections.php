<?php
ob_start();
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
        <title>收藏的電子書</title>
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
        <!-- Modal for search -->
        <div class="modal fade" id="search_icon" tabindex="-1" aria-labelledby="search_icon" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">                    
                    <h5 class="modal-title" id="search_icon">珍藏書查詢</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-inline my-2 my-lg-0" method="get" action="./collections.php">
                        <input class="form-control mr-sm-2" name="target_book" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>                        
                    </form>
                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                    
                </div>
                </div>
            </div>
        </div> 
        <?php
        // Modal for display book details
        $sql = "SELECT * FROM authors";
        $result = mysqli_query($conn, $sql);
        $all_authors = mysqli_fetch_all($result, MYSQLI_ASSOC);                 
        $sql = "SELECT * FROM author_book";
        $result = mysqli_query($conn, $sql);
        $author_to_book = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $sql = "SELECT * FROM publishers";
        $result = mysqli_query($conn, $sql);
        $publishers = mysqli_fetch_all($result, MYSQLI_ASSOC);     
        $sql = "SELECT * FROM books";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $num_of_rows = mysqli_num_rows($result);           
        $authorsOfBook = [];
        foreach($row as $book){
            $tmp = "";
            foreach($author_to_book as $relation){
                if($book["book_id"] == $relation["book_id"]){
                    if(strlen($tmp) != 0){
                        $tmp .= ", ";   
                    }
                    $tmp .= $all_authors[$relation["author_id"]-1]["first_name"];
                    $tmp .= " " . $all_authors[$relation["author_id"]-1]["last_name"];               
                }                
            }
            array_push($authorsOfBook, $tmp);
        }       
        for($i=0; $i<$num_of_rows; $i++){
            echo "<div class=\"modal fade\" id=\"modal_{$row[$i]["book_id"]}\" tabindex=\"-1\" aria-labelledby=\"{$row[$i]["isbn"]}\" aria-hidden=\"true\">
                                <div class=\"modal-dialog modal-dialog-scrollable modal-lg\">
                                    <div class=\"modal-content\">
                                    <div class=\"modal-header bg-secondary\">                    
                                        <!---<h5 class=\"modal-title\" id=\"{$row[$i]["book_id"]}\">{$row[$i]["title"]}</h5>-->
                                        <button type=\"button\" class=\"close text-white\" data-dismiss=\"modal\" aria-label=\"Close\">
                                        <span aria-hidden=\"true\">&times;</span>
                                        </button>                                        
                                    </div>
                                    <div class=\"modal-body\">
                                        <div class=\"card mb-3\" style=\"max-width: 800px;\">
                                            <div class=\"row no-gutters\">
                                            <div class=\"col-md-4\">
                                                <img src=\"./images/{$row[$i]["title"]}.jpg\" style=\"width: 100%; height: auto;\" class=\"card-img-top mx-auto\" alt=\"atomic_habit book\">
                                            </div>
                                            <div class=\"col-md-8\">
                                                <div class=\"card-body\">
                                                    <h5 class=\"card-title\">{$row[$i]["title"]}</h5> 
                                                    <!-- 這邊要放作者、出版社、ISBN、年份 -->                  
                                                    <p>作者: {$authorsOfBook[$i]}</p>                             
                                                    <p>出版商: {$publishers[$i]["publisher_name"]}</p> 
                                                    <p>ISBN: {$row[$i]["isbn"]}</p> 
                                                    <p>出版年份: {$row[$i]["year"]}</p> 
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <p class=\"h3 font-weight-bold\">簡介</p>
                                        <p>{$row[$i]["description"]}</p>
                                    </div>
                                    </div>
                                    <div class=\"modal-footer\">                    
                                        <form method=\"post\" action=\"like_books.php\">
                                            <input name=\"user_id\" type=\"hidden\" value=\"{$_SESSION["id"]}\" ></input>
                                            <input name=\"book_id\" type=\"hidden\" value=\"{$row[$i]["book_id"]}\" ></input>";
                                            $sql = "SELECT * FROM user_book";
                                            $result = mysqli_query($conn, $sql);
                                            $user_to_book = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                            $isAlreadyCollect = false;
                                            foreach($user_to_book as $userBook){
                                                if($_SESSION["id"] == $userBook["user_id"] && $row[$i]["book_id"] == $userBook["book_id"]){
                                                    echo "<button type=\"submit\" name=\"unlike_book\" class=\"btn btn-danger\">取消珍藏</button>";
                                                    $isAlreadyCollect = true;
                                                    break;
                                                }
                                            }
                                            if(!$isAlreadyCollect){
                                                echo "<button type=\"submit\" name=\"like_book\" class=\"btn btn-warning\">珍藏</button>";
                                            }
                                        echo "</form>
                                    </div>
                                    </div>                                                                                                
                                </div>                                
                            </div>";
        }                                     
        ?>     
        <div class="jumbotron jumbotron-fluid">
            <button class="btn" data-toggle="modal" data-target="#account_icon"><img src="./images/account_icon.png" alt="account icon" class="rounded-circle bg-white position-absolute" style="width: 4%; left: 34px; top: 25px;"></button>
            <button class="btn" data-toggle="modal" data-target="#search_icon"><img src="./images/search_icon.png" alt="search icon" class="position-absolute" style="width: 6%; right: 100px; top: 21px;"></button>  
            <a class="btn" href="./home.php"><img src="./images/home-menu-icon.jpg" alt="home menu icon" class="position-absolute" style="width: 4%; right: 30px; top: 25px;"></a>          
            <div class="container">
                <h1 class="display-1 text-center"><a href="./collections.php" style="text-decoration: none; color: white">COLLECTION</a></h1>            
            </div>
        </div>       
        <div class="container-fluid">        
            <div class="row justify-content-around">
                    <?php 
                    if(isset($_GET["target_book"])) {                        
                        $target_book = $_GET["target_book"];                       
                        $sql_title = "SELECT * FROM books INNER JOIN user_book ON books.book_id=user_book.book_id WHERE user_id='" . $_SESSION["id"] . "'";                        
                        $result = mysqli_query($conn, $sql_title);
                        $all_result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        $num_of_rows = mysqli_num_rows($result);  
                        if($num_of_rows == 0){
                            header("Location: collections.php?error=找不到此書籍");
                        }
                        foreach($all_result as $row){
                            echo "<div class=\"col-md-2 mb-3 card\" style=\"width: 180px; height: auto;\"data-toggle=\"modal\" data-target=\"#modal_{$row["book_id"]}\">
                            <img src=\"./images/{$row["title"]}.jpg\" style=\"width: 60%; height: 180px;\" class=\"card-img-top mx-auto\" alt=\"atomic_habit book\">
                            <div class=\"card-body\">
                                <h5 class=\"card-title text-center\">{$row["title"]}</h5>                            
                            </div>
                            </div>";
                        }                        
                    }
                    else if(isset($_GET["error"])){
                        echo "<p class=\"display-4 text-danger text-center\">你沒有珍藏任何書籍</p>";
                    }                                         
                    else{
                        $hasCollection = false;
                        $sql = "SELECT * FROM user_book";
                        $result = mysqli_query($conn, $sql);
                        $user_to_book = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        $result = mysqli_query($conn, "SELECT * FROM books");
                        $books = mysqli_fetch_all($result, MYSQLI_ASSOC);                        
                        foreach($user_to_book as $row){ // list all collections of user from the database
                            if($_SESSION["id"] == $row["user_id"]){
                                $hasCollection = true;
                                foreach($books as $book){
                                    if($book["book_id"] == $row["book_id"]){
                                        echo "<div class=\"col-md-2 mb-3 m-1 card\" style=\"width: 180px; height: auto;\"data-toggle=\"modal\" data-target=\"#modal_{$row["book_id"]}\">
                                        <button type=\"button\" class=\"btn\"><img src=\"./images/{$book["title"]}.jpg\" style=\"width: 60%; height: 180px;\" class=\"card-img-top mx-auto\" alt=\"atomic_habit book\"></button>
                                        <div class=\"card-body\">
                                        <h5 class=\"card-title text-center\">{$book["title"]}</h5>                            
                                        </div>
                                        </div>";
                                    }
                                }                                
                            }
                        }
                        if(!$hasCollection){ // 沒有珍藏的電子書
                            echo "<p class=\"display-4 text-danger\">沒有珍藏的書籍喔</p>";
                        }
                    } 
                    ?>                                    
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
ob_end_flush();
?>