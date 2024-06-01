<?php
include('api/conn.php');
session_start();

if (empty($_SESSION['username'])) {
    // Redirect ke halaman selamat datang
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM cuaca ORDER BY id DESC LIMIT 1";
$result = $conn->query($query);
$row = $result->fetch_object();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Monitoring Cuaca</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-cloud-sun"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Monitoring Cuaca</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="./index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="./report.php">
                    <i class="fas fa-fw fa-bars"></i>
                    <span>Report</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <!-- <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div> -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['username'] ?> </span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>


                    <!-- Hero -->
                    <div class="row" style="height: 75vh;">
                        <div class="col-lg-12">
                            <div class="card p-5 shadow h-100 py-2 rounded" style="background-image: linear-gradient(to right, #3b1aa9, #50a7ee);">
                                <div class="row my-5">
                                    <div class=" col-xl-6 col-lg-12 text-center pt-3 pb-3">
                                        <h1 style="color: white;">SURAKARTA</h1>
                                        <h2 style="color: white;">
                                            <?php
                                            echo $tanggalFormatted = date('l  d F Y');
                                            ?>
                                        </h2>
                                        <h1 class="font-weight-bold" style="color: white;"><span id="temp1"></span> °C</h1>
                                        <!-- <div class="rounded-pill font-weight-bold" style="background-color: #ffda50;color:#3b1aa9;">
                                            CERAH BERAWAN
                                        </div> -->
                                    </div>
                                    <div class="col-xl-6 col-lg-12 text-center">
                                        <img src="img/cuaca/cerah-berawan.png" alt="cuaca">

                                        <div class="d-flex text-white  text-center mt-3">
                                            <div class="text-center col-2" title="Suhu Udara">
                                                <i class="fas fa-temperature-low"></i>
                                                <p><span id="temp"></span> °C</p>
                                            </div>
                                            <div class="text-center col-2" title="Kelembapan Udara">
                                                <i class="fas fa-tint"></i>
                                                <p><span id="hum"></span> %</p>
                                            </div>
                                            <div class="text-center col-2" title="Kecepatan Angin">
                                                <i class="weather-icon fa fa-wind"></i>
                                                <p><span id="wind"></span> M/s</p>
                                            </div>
                                            <div class="text-center  col-2" title="Tekanan Udara">
                                                <i class="weather-icon fa fa-water"></i>
                                                <p><span id="pressure"></span> Pa</p>
                                            </div>
                                            <div class="text-center  col-2" title="Intensitas Cahaya">
                                                <i class="far fa-sun"></i>
                                                <p><span id="inten"></span> %</p>
                                            </div>
                                            <div class="text-center  col-2" title="Ketinggian Dari Permukaan Laut">
                                                <i class="fas fa-mountain"></i>
                                                <p><span id="altitude"></span> M</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="display: none;">
                                    <div class="col-12">
                                        <div class="card p-2" style="background: rgba(0, 0, 0, 0.3);border:none;">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="card" style="height: 15vh;">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="card" style="height: 15vh;">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="card" style="height: 15vh;">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="card" style="height: 15vh;">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="card" style="height: 15vh;">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="card" style="height: 15vh;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Hero -->



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; KelIot2 <?= date('Y'); ?> </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="api/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <script>
        function fetchData() {
            fetch('api/status.php')
                .then(response => response.json())
                .then(data => {
                    // Assuming data is an array with a single object
                    const weatherData = data[0];

                    // Update HTML elements with the new data
                    document.getElementById('temp').innerText = weatherData.suhu_udara;
                    document.getElementById('temp1').innerText = weatherData.suhu_udara;
                    document.getElementById('hum').innerText = weatherData.kelembapan_udara;
                    document.getElementById('wind').innerText = weatherData.kecepatan_angin;
                    document.getElementById('pressure').innerText = weatherData.tekanan;
                    document.getElementById('altitude').innerText = weatherData.altitude;
                    document.getElementById('inten').innerText = weatherData.intensitas_cahaya;
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        fetchData();
        // Set interval to update data every  seconds
        setInterval(fetchData, 2500);
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/chart-area.js"></script>
    <!-- <script src="js/demo/chart-area-demo.js"></script> -->
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>