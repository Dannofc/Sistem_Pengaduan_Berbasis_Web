<?php
    require_once("private/database.php");
    $message = "";
    if (isset($_POST['register']) && $_POST['register'] == "Buat Akun") {
        $reg_username = $_POST['reg_username'];
        $reg_password = $_POST['reg_password'];

        // Cek apakah username sudah ada
        $cek = $db->prepare("SELECT * FROM user WHERE username = :username");
        $cek->bindValue(':username', $reg_username);
        $cek->execute();
        if ($cek->rowCount() > 0) {
            $message = "Username sudah digunakan!";
        } else {
            // Simpan user baru (tanpa email)
            $insert = $db->prepare("INSERT INTO user (username, password) VALUES (:username, SHA2(:password, 0))");
            $insert->bindValue(':username', $reg_username);
            $insert->bindValue(':password', $reg_password);
            if ($insert->execute()) {
                $message = "Akun berhasil dibuat, silakan login.";
            } else {
                $message = "Gagal membuat akun.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrasi Akun - Pengaduan Dispenduk Tanjung Bonai Aur</title>
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="css/user.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card container card-login mx-auto mt-5">
            <h3 class="text-center" style="padding-top:8px; font-family: monospace;">Buat Akun</h3>
            <hr class="custom">
            <div class="card-body">
                <form method="post" autocomplete="off">
                    <div class="form-group">
                        <label class="username" for="exampleInputEmail1">Username</label>
                        <input class="form-control" id="username" type="text" name="reg_username" placeholder="Username baru" required>
                    </div>
                    <div class="form-group">
                        <label class="password" for="exampleInputPassword1">Password</label>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Password baru" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block card-shadow-2" style="margin-top:30px; margin-bottom:20px;" name="register" value="Buat Akun">Buat Akun</button>
                </form>
                <?php if(!empty($message)): ?>
                    <p class="text-center text-danger mt-2"><small><?php echo $message; ?></small></p>
                <?php endif; ?>
                <div class="text-center mt-3" style="padding-bottom: 20px;">
                    <a href="login.php" class="text-link">Sudah punya akun? Login</a>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>