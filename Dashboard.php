<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "sis";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query total students
$totalSiswaQuery = "SELECT COUNT(*) as total FROM dataSiswa";
$totalSiswaResult = $connection->query($totalSiswaQuery);
$totalSiswa = $totalSiswaResult->fetch_assoc()['total'];

// Query students who have been added recently (siswa masuk)
$siswaMasukQuery = "SELECT COUNT(*) as total FROM dataSiswa WHERE status = 'LULUS'";
$siswaMasukResult = $connection->query($siswaMasukQuery);
$siswaMasuk = $siswaMasukResult->fetch_assoc()['total'];

// Query students who have been removed (siswa keluar)
$siswaBlmLulusQuery = "SELECT COUNT(*) as total FROM dataSiswa WHERE status = 'BELUM LULUS'";
$siswaBlmLulusResult = $connection->query($siswaBlmLulusQuery);
$siswaBlmLulus = $siswaBlmLulusResult->fetch_assoc()['total'];

// Query total teachers
$totalGuruQuery = "SELECT COUNT(*) as total FROM dataGuru";
$totalGuruResult = $connection->query($totalGuruQuery);
$totalGuru = $totalGuruResult->fetch_assoc()['total'];

// Koneksi ke database MySQL
$mysqli = new mysqli("localhost", "root", "", "sis");

// Periksa koneksi
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query untuk mengambil data
$query = "SELECT tahun, COUNT(*) as jumlah_orang FROM datasiswa GROUP BY tahun";

// Persiapan statement
if ($stmt = $mysqli->prepare($query)) {
    // Eksekusi statement
    $stmt->execute();

    // Bind hasil ke variabel
    $stmt->bind_result($tahun, $jumlah_orang);

    // Ambil hasil query dan simpan ke array
    $result_array = array();
    while ($stmt->fetch()) {
        $result_array[] = array(
            'tahun' => $tahun,
            'jumlah_orang' => $jumlah_orang
        );
    }

    // Mengonversi array PHP ke format JSON
    $json_array = json_encode($result_array);

    // Menutup statement
    $stmt->close();
}

// Menutup koneksi
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="dashboard.js"></script>
    <!-- <script src="js/demo/chart-area-demo.js"></script> -->
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse dropdown-center" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">SIS (Sistem Informasi Siswa)</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ADMIN
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="LoginPage.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- sidebar -->
    <button class="btn btn-outline-secondary m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
        <i class="bi bi-chevron-double-right"></i>
    </button>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Logo</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <a class="dropdown-item" href="Dashboard.php">Dashboard</a>
            <a class="dropdown-item" href="DataSiswa.php">Data Siswa</a>
            <a class="dropdown-item" href="DataKelas.php">Data Kelas</a>
            <a class="dropdown-item" href="DataGuru.php">Data Guru</a>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-red-800">DASHBOARD</h1>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-center">
        <div class="row w-100">
            <!-- Total Students Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-blue shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-blue text-uppercase mb-1">
                                    TOTAL SISWA</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalSiswa; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Students Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-green shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-blue text-uppercase mb-1">
                                    SISWA LULUS</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $siswaMasuk; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Left Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-lblue shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-lblue text-uppercase mb-1">
                                    SISWA BELUM LULUS</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="siswaKeluar"><?php echo $siswaBlmLulus; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Teachers Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-yellow shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-yellow text-uppercase mb-1">
                                    TOTAL GURU</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalGuru; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="container-fluid d-flex justify-content-center">
        <div class="card shadow mb-7 w-100" style="max-width: 1100px;">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="js/demo/dashboard.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var arrayObjects = <?php echo $json_array; ?>;
        // Extract labels and data from the arrayObjects
        const labels = arrayObjects.map(item => item.tahun);
        const earningsData = arrayObjects.map(item => item.jumlah_orang);

        // Create the chart
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Earnings",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: earningsData,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '$' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    });
</script>
</body>
</html>
