<?php
require_once("database.php");
require_once("auth.php"); // Session
logged_admin ();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Export - Pengaduan Dispenduk Tanjung Bonai Aur</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/admin.css" rel="stylesheet">
    <!-- Page level plugin CSS-->
    <link rel="stylesheet" type="text/css" href="vendor/datatables/extra/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/datatables/extra/buttons.dataTables.min.css">

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- export plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/extra/dataTables.buttons.min.js"></script>
    <script src="vendor/datatables/extra/buttons.print.min.js"></script>
    <script src="vendor/datatables/extra/jszip.min.js"></script>
    <script src="vendor/datatables/extra/pdfmake.min.js"></script>
    <script src="vendor/datatables/extra/vfs_fonts.js"></script>
    <script src="vendor/datatables/extra/buttons.html5.min.js"></script>
    <script type="text/javascript"  class="init">
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: 'Data Pengaduan',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                        $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<img src="http://www.surabaya.bpk.go.id/wp-content/uploads/2015/07/logo-Bangkalan.png" style="opacity: 0.5; display:block;margin-left: auto; margin-top: auto; margin-right: auto; width: 100px;" />'
                        );
                    }
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: 'Data Pengaduan'
                },
                {
                    extend: 'excel',
                    title: 'Data Pengaduan'
                }
            ]
        } );
    } );
    </script>

</head>

<body class="fixed-nav sticky-footer" id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <a class="navbar-brand" href="index">Dispenduk Tanjung Bonai Aur</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav sidebar-menu" id="exampleAccordion">

                <li class="sidebar-profile nav-item" data-toggle="tooltip" data-placement="right" title="Admin">
                    <div class="profile-main">
                        <p class="image">
                            <img alt="image" src="images/avatar1.png" width="80">
                            <span class="status"><i class="fa fa-circle text-success"></i></span>
                        </p>
                        <p>
                            <span class="">Admin</span><br>
                            <span class="user" style="font-family: monospace;"><?php echo $divisi; ?></span>
                        </p>
                    </div>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="index">
                        <i class="fa fa-fw fa-dashboard"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
                    <a class="nav-link" href="tables">
                        <i class="fa fa-fw fa-table"></i>
                        <span class="nav-link-text">Kelola</span>
                    </a>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Export">
                    <a class="nav-link" href="export">
                        <i class="fa fa-fw fa-print"></i>
                        <span class="nav-link-text">Ekspor</span>
                    </a>
                </li>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Version">
                    <a class="nav-link" href="#VersionModal" data-toggle="modal" data-target="#VersionModal">
                        <i class="fa fa-fw fa-code"></i>
                        <span class="nav-link-text">v-6.0</span>
                    </a>
                </li>

            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-fw fa-envelope"></i>
                        <span class="d-lg-none">Messages
                            <span class="badge badge-pill badge-primary">12 New</span>
                        </span>
                        <span class="indicator text-primary d-none d-lg-block">
                            <i class="fa fa-fw fa-circle"></i>
                        </span>
                    </a>
                    <?php
                        $statement = $db->query("SELECT * FROM laporan ORDER BY laporan.id DESC LIMIT 1");
                        foreach ($statement as $key ) {
                            $mysqldate = $key['tanggal'];
                            $phpdate = strtotime($mysqldate);
                            $tanggal = date( 'd/m/Y', $phpdate);
                     ?>
                    <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                        <h6 class="dropdown-header">Laporan Baru :</h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <strong><?php echo $key['nama']; ?></strong>
                            <span class="small float-right text-muted"><?php echo $key['tanggal']; ?></span>
                            <div class="dropdown-message small"><?php echo $key['isi']; ?></div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <!-- <a class="dropdown-item small" href="#">View all messages</a> -->
                    </div>
                    <?php
                        }
                     ?>

                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-fw fa-sign-out"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>


    <!-- Body -->
    <div class="content-wrapper">
        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Ekspor</a>
                </li>
                <li class="breadcrumb-item active"><?php echo $divisi; ?></li>
            </ol>

            <!-- DataTables Card-->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Cetak Laporan Masuk
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="example" width="100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telpon</th>
                                    <th>Alamat</th>
                                    <th>Tujuan</th>
                                    <th>Isi Laporan</th>
                                    <th>Lampiran</th>
                                    <th>Tanggal</th>
                                    <th class="sorting_asc_disabled sorting_desc_disabled">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Ambil semua record dari tabel laporan
                                if ($id_admin > 0) {
                                    $statement = $db->query("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi AND laporan.tujuan = $id_admin ORDER BY laporan.id DESC");
                                } else {
                                    $statement = $db->query("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi ORDER BY laporan.id DESC");
                                }

                                foreach ($statement as $key ) {
                                    $mysqldate = $key['tanggal'];
                                    $phpdate = strtotime($mysqldate);
                                    $tanggal = date( 'd/m/Y', $phpdate);
                                    $status  = $key['status'];
                                    if($status == "Ditanggapi") {
                                        $style_status = "<p style=\"background-color:#009688;color:#fff;padding-left:2px;padding-right:2px;padding-bottom:2px;margin-top:16px;font-size:15px;font-style:italic;\">Ditanggapi</p>";
                                    } else {
                                        $style_status = "<p style=\"background-color:#FF9800;color:#fff;padding-left:2px;padding-right:2px;padding-bottom:2px;margin-top:16px;font-size:15px;font-style:italic;\">Menunggu</p>";
                                    }
                                    // Lampiran
                                    $lampiran = '';
                                    if (!empty($key['file'])) {
                                        $ext = strtolower(pathinfo($key['file'], PATHINFO_EXTENSION));
                                        $is_image = in_array($ext, ['jpg','jpeg','png','gif','bmp']);
                                        $file_url = "../uploads/" . $key['file'];
                                        if ($is_image) {
                                            $lampiran = "<a href='$file_url' target='_blank'><img src='$file_url' alt='Lampiran' style='max-width:60px;max-height:60px;border-radius:4px;'></a>";
                                        } else {
                                            $lampiran = "<a href='$file_url' target='_blank' class='btn btn-xs btn-info'>Download</a>";
                                        }
                                    } else {
                                        $lampiran = "<span class='text-muted'>-</span>";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $key['nama']; ?></td>
                                        <td><?php echo $key['email']; ?></td>
                                        <td><?php echo $key['telpon']; ?></td>
                                        <td><?php echo $key['alamat']; ?></td>
                                        <td><?php echo $key['nama_divisi']; ?></td>
                                        <td><?php echo $key['isi']; ?></td>
                                        <td><?php echo $lampiran; ?></td>
                                        <td><?php echo $tanggal; ?></td>
                                        <td><?php echo $style_status; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
        </div>
        <!-- /.container-fluid-->

        <footer class="sticky-footer">
            <div class="container">
                <div class="text-center">
                    <small>Copyright © Dispenduk Tanjung Bonai Aur 2018</small>
                </div>
            </div>
        </footer>


        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fa fa-angle-up"></i>
        </a>


        <!-- Logout Modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin Ingin Keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Logout" jika anda ingin mengakhiri sesi.</div>
                    <div class="modal-footer">
                        <button class="btn btn-close card-shadow-2 btn-sm" type="button" data-dismiss="modal">Batal</button>
                        <a class="btn btn-primary btn-sm card-shadow-2" href="logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Version Info Modal -->
        <!-- Modal -->
        <div class="modal fade" id="VersionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Admin Versi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 style="text-align : center;">V-6.0</h5>
                        <p style="text-align : center;">Copyright © Dispenduk Tanjung Bonai Aur 2018</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-close card-shadow-2 btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/admin.js"></script>
        <!-- Custom scripts for this page-->
        <script src="js/admin-datatables.js"></script>

    </div>
    <!-- /.content-wrapper-->

</body>

</html>
