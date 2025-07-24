<?php
require_once("private/database.php");
require_once("auth.php");

// Ambil data user
$stmt = $db->prepare("SELECT * FROM user WHERE username = :username LIMIT 1");
$stmt->bindValue(':username', $_SESSION['user']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Proses upload foto profil
if (isset($_POST['upload_foto'])) {
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_type = mime_content_type($file_tmp);
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        if (in_array($file_type, $allowed)) {
            $foto_data = file_get_contents($file_tmp);
            $stmt = $db->prepare("UPDATE user SET foto = :foto WHERE username = :username");
            $stmt->bindValue(':foto', $foto_data, PDO::PARAM_LOB);
            $stmt->bindValue(':username', $_SESSION['user']);
            if ($stmt->execute()) {
                // Refresh data user setelah update
                $stmt2 = $db->prepare("SELECT * FROM user WHERE username = :username LIMIT 1");
                $stmt2->bindValue(':username', $_SESSION['user']);
                $stmt2->execute();
                $user = $stmt2->fetch(PDO::FETCH_ASSOC);
                $success = "Foto profil berhasil diubah!";
            } else {
                $error = "Gagal mengubah foto profil.";
            }
        } else {
            $error = "Format file tidak didukung. Hanya JPG/PNG.";
        }
    } else {
        $error = "Pilih file gambar terlebih dahulu.";
    }
}

// Proses update username & password
if (isset($_POST['update_user'])) {
    $new_username = trim($_POST['edit_username']);
    $new_password = trim($_POST['edit_password']);

    // Validasi username tidak boleh kosong
    if ($new_username == '') {
        $error = "Username tidak boleh kosong.";
    } else {
        // Cek jika username sudah digunakan user lain
        $cek = $db->prepare("SELECT * FROM user WHERE username = :username AND username != :old_username");
        $cek->bindValue(':username', $new_username);
        $cek->bindValue(':old_username', $user['username']);
        $cek->execute();
        if ($cek->rowCount() > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Update username dan/atau password
            if ($new_password != '') {
                $update = $db->prepare("UPDATE user SET username = :username, password = SHA2(:password, 0) WHERE username = :old_username");
                $update->bindValue(':username', $new_username);
                $update->bindValue(':password', $new_password);
                $update->bindValue(':old_username', $user['username']);
            } else {
                $update = $db->prepare("UPDATE user SET username = :username WHERE username = :old_username");
                $update->bindValue(':username', $new_username);
                $update->bindValue(':old_username', $user['username']);
            }
            if ($update->execute()) {
                $_SESSION['user'] = $new_username;
                // Refresh data user
                $stmt2 = $db->prepare("SELECT * FROM user WHERE username = :username LIMIT 1");
                $stmt2->bindValue(':username', $new_username);
                $stmt2->execute();
                $user = $stmt2->fetch(PDO::FETCH_ASSOC);
                $success = "Data berhasil diubah.";
            } else {
                $error = "Gagal mengubah data.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Profil | Dispendukcapil Tanjung Bonai Aur</title>
    <link rel="icon" href="images/icon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="shadow">
        <nav class="navbar navbar-fixed navbar-inverse form-shadow">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index">
                        <img alt="Brand" src="images/icon.png">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index">HOME</a></li>
                        <li><a href="lapor">LAPOR</a></li>
                        <li><a href="lihat">LIHAT PENGADUAN</a></li>
                        <li><a href="cara">CARA</a></li>
                        <li class="dropdown">
                            <a href="profildinas" class="dropdown-toggle" data-toggle="dropdown">PROFIL DINAS <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="profildinas#profil">Profil Dinas</a></li>
                                <li class="divider"></li>
                                <li><a href="profildinas#visi">Visi dan Misi</a></li>
                                <li class="divider"></li>
                                <li><a href="profildinas#struktur">Struktur Organisasi</a></li>
                                <li class="divider"></li>
                                <li><a href="profildinas#motto">Motto / Maklumat Pelayanan</a></li>
                            </ul>
                        </li>
                        <li><a href="faq">FAQ</a></li>
                        <li><a href="bantuan">BANTUAN</a></li>
                        <li><a href="kontak">KONTAK</a></li>
                        <li class="dropdown active">
                            <a href="profil" class="dropdown-toggle" data-toggle="dropdown">PROFIL <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="profil">Profil Saya</a></li>
                                <li class="divider"></li>
                                <li><a href="logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav><!-- /.nav -->

        <div class="container">
            <div class="card container card-login mx-auto mt-5">
                <h3 class="text-center" style="padding-top:8px; font-family: monospace;">Profil Saya</h3>
                <hr class="custom">
                <div class="foto-profil text-center">
                    <!-- Foto profil preview -->
                    <img id="preview-foto" src="data:image/jpeg;base64,<?php echo base64_encode($user['foto']); ?>" name="foto" class="img-profil" style="width: 150px; height: 150px; object-fit:cover;">
                    
                    <!-- Form upload foto profil -->
                    <form method="post" enctype="multipart/form-data" id="form-foto" style="margin-top:16px;">
                        <input type="file" id="input-foto" name="foto" accept="image/*" style="display:none;" onchange="previewFoto(this)">
                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('input-foto').click();">Ubah Foto Profil</button>
                        <br>
                        <button type="submit" name="upload_foto" id="btn-konfirmasi" class="btn btn-success btn-sm mt-3" style="display:none;">Konfirmasi & Simpan</button>
                    </form>

                    <!-- Form Username & Password (readonly, seperti form) -->
                    <form class="mt-4" style="max-width:300px;margin:24px auto 0 auto;">
                        <div class="form-group text-left">
                            <label for="username-view" style="font-weight:600;">Username</label>
                            <input type="text" class="form-control" id="username-view" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                        </div>
                        <div class="form-group text-left">
                            <label for="password-view" style="font-weight:600;">Password</label>
                            <input type="password" class="form-control" id="password-view" value="********" readonly>
                        </div>
                    </form>

                    <!-- Edit Username & Password -->
                    <button class="btn btn-warning btn-sm mt-2" onclick="showEditForm()">Edit Username & Password</button>
                    <form method="post" id="edit-user-form" style="display:none; margin-top:16px; max-width:300px; margin-left:auto; margin-right:auto;">
                        <div class="form-group text-left">
                            <label for="edit-username">Username</label>
                            <input type="text" class="form-control" id="edit-username" name="edit_username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>
                        <div class="form-group text-left">
                            <label for="edit-password">Password Baru</label>
                            <input type="password" class="form-control" id="edit-password" name="edit_password" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <button type="submit" name="update_user" class="btn btn-success btn-block btn-sm">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary btn-block btn-sm mt-2" onclick="hideEditForm()">Batal</button>
                    </form>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success mt-2"><?php echo $success; ?></div>
                    <?php elseif (!empty($error)): ?>
                        <div class="alert alert-danger mt-2"><?php echo $error; ?></div>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
    </div>
    <hr>
    <footer class="footer text-center">
        <div class="row">
            <div class="col-md-4 mb-5 mb-lg-0">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <i class="fa fa-top fa-map-marker"></i>
                    </li>
                    <li class="list-inline-item">
                        <h4 class="text-uppercase mb-4">Kantor</h4>
                    </li>
                </ul>
                <p class="mb-0">
                    Baringin, Kec. Lima Kaum, Kabupaten Tanah Datar, 
                    <br>Sumatera Barat 27211
                </p>
            </div>
            <div class="col-md-4 mb-5 mb-lg-0">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <i class="fa fa-top fa-rss"></i>
                    </li>
                    <li class="list-inline-item">
                        <h4 class="text-uppercase mb-4">Sosial Media</h4>
                    </li>
                </ul>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://www.facebook.com/tanahdatar.disdukcapil/">
                            <i class="fa fa-fw fa-facebook"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://www.instagram.com/dukcapil_tanahdatar/?hl=id">
                            <i class="fa fa-fw fa-instagram"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <i class="fa fa-top fa-envelope-o"></i>
                    </li>
                    <li class="list-inline-item">
                        <h4 class="text-uppercase mb-4">Kontak</h4>
                    </li>
                </ul>
                <p class="mb-0">
                    08-1234567890 <br>
                    tanjungbonaiaur.go.id <br>
                    tanjungbonaiaur@gmail.com
                </p>
            </div>
        </div>
    </footer>
                <!-- /footer -->

            <div class="copyright py-4 text-center text-white">
                <div class="container">
                <small>Copyright &copy; Pemerintahan Tanjung Bonai Aur</small>
                </div>
            </div>
        <!-- shadow -->
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>
    <script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-foto').src = e.target.result;
            document.getElementById('btn-konfirmasi').style.display = 'inline-block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function showEditForm() {
    document.getElementById('edit-user-form').style.display = 'block';
}
function hideEditForm() {
    document.getElementById('edit-user-form').style.display = 'none';
}
</script>

</body>

</html>
