<?php
    require_once("private/database.php");
    require_once("auth.php");

    // Ambil data user dari database
    $user = null;
    if (isset($_SESSION['user'])) {
        $stmt = $db->prepare("SELECT * FROM user WHERE username = :username LIMIT 1");
        $stmt->bindValue(':username', $_SESSION['user']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>
<?php
// fungsi untuk merandom avatar profil
function RandomAvatar(){
    $photoAreas = array("avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png", "avatar5.png", "avatar6.png", "avatar7.png", "avatar8.png", "avatar9.png", "avatar10.png", "avatar11.png");
    $randomNumber = array_rand($photoAreas);
    $randomImage = $photoAreas[$randomNumber];
    echo $randomImage;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Dispendukcapil Tanjung Bonai Aur</title>
    <link rel="icon" href="images/icon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    <style>
        .navbar-profile {
            position: relative;
            display: flex;
            align-items: center;
        }
        .navbar-profile .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
            border: 2px solid #eee;
        }
        .navbar-profile .username {
            font-weight: 500;
            color: #009688;
            margin-right: 8px;
        }
        .profile-dropdown {
            position: absolute;
            top: 48px;
            right: 0;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            min-width: 120px;
            z-index: 1000;
            display: none;
        }
        .profile-dropdown.show {
            display: block;
        }
        .profile-dropdown a {
            display: block;
            padding: 10px 18px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #eee;
        }
        .profile-dropdown a:last-child {
            border-bottom: none;
        }
        .profile-dropdown a:hover {
            background: #f5f5f5;
        }
    </style>
</head>

<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.11';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <!--Success Modal Saved-->
    <div class="modal fade" id="successmodalclear" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm " role="document">
            <div class="modal-content bg-2">
                <div class="modal-header ">
                    <h4 class="modal-title text-center text-green">Sukses</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Pengaduan Berhasil Di Kirim</p>
                    <p class="text-center">Untuk Mengetahui Status Pengaduan</p>
                    <p class="text-center">Silahkan Buka Menu <a href="lihat">Lihat Pengaduan</a> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn button-green" onclick="location.href='index';" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_GET['status'])) {
    ?>
    <script type="text/javascript">
        $("#successmodalclear").modal();
    </script>
    <?php
        }
    ?>
    <!-- body -->
    <div class="shadow">
        <!-- navbar -->
        <nav class="navbar navbar-inverse navbar-fixed form-shadow">
            <!-- container-fluid -->
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="">
                        <img alt="Brand" src="images/icon.png">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav nav-link">
                        <li class="active"><a href="">HOME</a></li>
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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">PROFIL <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="profil">Profil Saya</a></li>
                                <li class="divider"></li>
                                <li><a href="logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php if($user): ?>
                    <?php endif; ?>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- end navbar -->

    <!-- start slider -->
    <div id="mainCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#mainCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#mainCarousel" data-slide-to="1"></li>
            <li data-target="#mainCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->

        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="images/baner_02.jpg" alt="...">
                <div class="carousel-caption welcome">
                    <h2 class="animated bounceInRight">Selamat Datang</h2>
                    <h3 class="animated bounceInLeft">Website Pengaduan Masyarakat Dispendukcapil Tanjung Bonai Aur</h3>
                </div>
            </div>
            <div class="item">
                <img src="images/header_01.jpg" alt="...">
                <div class="carousel-caption">
                    <h2 class="animated bounceInDown">Pejabat</h2>
                </div>
            </div>
            <div class="item">
                <img src="images/header_03.jpg" alt="...">
                <div class="carousel-caption">
                    <h2 class="animated bounceInUp">Pengumuman</h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#mainCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#mainCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- end Slider -->

    <!-- content -->
    <div class="main-content">
        <!-- section -->
        <div class="section">
            <div class="row">
                <!-- laporan Terbaru -->
                <div class="col-md-8">
                    <br>
                    <h3 class="text-center h3-custom">Pengaduan Terbaru</h3>
                    <hr class="custom-line"/>
                    <hr>
                    <!-- scroll-laporan -->
                    <div class="scroll-laporan">
                        <?php
                        // Ambil semua record dari tabel laporan
                        $statement = $db->query("SELECT * FROM `laporan` ORDER BY id DESC");
                        foreach ($statement as $key ) {
                            $mysqldate = $key['tanggal'];
                            $phpdate = strtotime($mysqldate);
                            $tanggal = date( 'd F Y, H:i:s', $phpdate);
                            ?>
                            <div class="panel-body card-shadow-2">
                                <a class="media-left" href="#"><img class="img-circle img-sm form-shadow" src="images/avatar/<?php RandomAvatar(); ?>"></a>
                                <div class="media-body">
                                    <div>
                                        <h4 class="text-green profil-name" style="font-family: monospace;"><?php echo $key['nama']; ?></h4>
                                        <p class="text-muted text-sm"><i class="fa fa-th fa-fw"></i>  -  <?php echo $tanggal; ?></p>
                                    </div>
                                    <hr class="hr-nama">
                                    <p>
                                        <?php echo $key['isi']; ?>
                                    </p>
                                </div>
                                <!-- media body -->
                            </div>
                            <!-- panel body -->

                            <?php
                        }
                        ?>

                    </div>
                    <!-- end scroll-laporan -->
                </div>
                <!-- End Laporan Terbaru -->

                <!-- Social Media Feed -->
                <div class="col-md-4">
                    <br>
                    <!-- header text social-feed -->
                    <h3 class="text-center h3-custom">Social Feed</h3>
                    <hr class="custom-line"/>
                    <!-- end header text social-feed -->
                    <!-- Instagram Feed -->
                    <div class="box">
                        <div class="box-icon shadow">
                            <span class="fa fa-2x fa-instagram"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">instagram</h3>
                            <a class="instagram-timeline" href="https://www.instagram.com/p/C_jiG3zSTHn/" data-width="500" data-height="300">Feed by Dukcapil Tanjung Bonai</a>
                            <script async src="https://platform.instagram.com/widgets.js" charset="utf-8"></script>
                        </div>
                    </div>
                    <!-- End Instagram Feed -->
                    <hr>
                    <!-- Facebook Feed -->
                    <div class="box">
                        <div class="box-icon shadow">
                            <span class="fa fa-2x fa-facebook"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">facebook</h3>
                            <div class="fb-page" data-height="300" data-width="500" data-href="https://www.facebook.com/tanahdatar.disdukcapil/?locale=id_ID" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                <blockquote cite="https://www.facebook.com/tanahdatar.disdukcapil/?locale=id_ID" class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/tanahdatar.disdukcapil/?locale=id_ID">Dispenduk dan Capil Tanjung Bonai Aur</a>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <!-- End Facebook Feed -->
                    <hr>
                    <!-- Facebook Feed -->
                    <div class="box">
                        <div class="box-icon shadow">
                            <span class="fa fa-2x fa-rss"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">link</h3>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><a href="">Website Pemerintah Tanah Datar</a></li>
                                <li class="list-group-item list-group-item-info"><a href="">Website Diskominfo Tanah Datar</a></li>
                                <li class="list-group-item list-group-item-warning"><a href="">Website Dispendukcapil Tanah Datar</a></li>
                                <li class="list-group-item list-group-item-danger"><a href="">Website Bappeda Tanah Datar</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Facebook Feed -->
                </div>
                <!-- End Social Media Feed -->
            </div>
            <!-- end row -->
        </div>
        <!-- /.section -->

        <!-- link to top -->
        <a id="top" href="#" onclick="topFunction()">
            <i class="fa fa-arrow-circle-up"></i>
        </a>
        <script>
        // When the user scrolls down 100px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};
        function scrollFunction() {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                document.getElementById("top").style.display = "block";
            } else {
                document.getElementById("top").style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
        </script>
        <!-- link to top -->

    </div>
    <!-- end main-content -->

    <!-- Footer -->
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
        <small>Copyright &copy; Pemerintahan Tanjung Bonai Aur</small>
    </div>
    <!-- shadow -->
</div>

<script>
    // Dropdown profil user
    $(function(){
        $('#profileMenu').on('click', function(e){
            e.stopPropagation();
            $('#profileDropdown').toggleClass('show');
        });
        $(document).on('click', function(e){
            if (!$(e.target).closest('#profileMenu').length) {
                $('#profileDropdown').removeClass('show');
            }
        });
    });
    </script>
</body>
</html>
