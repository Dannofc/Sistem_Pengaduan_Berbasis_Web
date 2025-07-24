<?php
    require_once("private/database.php");
    $message = "";
    // Proses login
    if (isset($_POST['login']) && $_POST['login'] == "Login") {
        $username    = $_POST['username'];
        $password    = $_POST['password'];
        $sql = "SELECT * FROM user WHERE username = :username and password = SHA2(:password, 0)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $valid_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($valid_user){
            session_start();
            $_SESSION["user"] = $username;
            header("Location: index");
            exit;
        } else {
            $message = "Username atau Password Salah";
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Login - Pengaduan Dispenduk Tanjung Bonai Aur</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/user.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card container card-login mx-auto mt-5">
            <h3 class="text-center" style="padding-top:8px; font-family: monospace;">Login User</h3>
            <hr class="custom">
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label class="username" for="exampleInputEmail1">Username</label>
                        <input class="form-control" id="username" type="text" name="username" aria-describedby="userlHelp" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label class="password" for="exampleInputPassword1">Password</label>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox"> Remember Password
                            </label>
                        </div>
                    </div>
                    
                    <input type="submit" class="btn btn-primary btn-block card-shadow-2" name="login" value="Login">
                </form>
                <?php if(!empty($message)): ?>
                    <p class="text-center text-danger mt-2"><small><?php echo $message; ?></small></p>
                <?php endif; ?>
                <div class="link-text mt-3">
                    <a href="registrasi.php" class="text-link">Belum punya akun?</a>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>