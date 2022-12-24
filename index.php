<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap-4.6.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <title>LOGIN</title>
</head>
<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-1 text-center">EBOOK</h1>            
        </div>
    </div>
    <form class="form-signin" action="./login.php" method="post">
        <?php if(isset($_GET["error"])) { ?>
            <p class="error"><?php echo $_GET["error"]; ?></p>
        <?php } ?>
        <!-- <h2 class="h3 mb-3 text-center">請登入</h2> -->
        <label for="inputUser" class="sr-only">帳號</label>
        <input type="text" id="inputUser" name="username" class="form-control mb-3" placeholder="帳號" required>
        <label for="inputPassword" class="sr-only">密碼</label>
        <input type="passowrd" id="inputPassword" name="password" class="form-control mb-3" placeholder="密碼" required>
        <button class="btn btn-login btn-lg btn-secondary btn-block text-white" type="submit">登入</button>     
        <a class="btn btn-register btn-lg btn-secondary btn-block mb-3 text-white" href="#">註冊</a>
        <p class="text-center">尚未擁有會員?</p>
    </form>
    
<script src="/bootstrap-4.6.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>