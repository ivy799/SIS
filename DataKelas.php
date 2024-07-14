<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sis";

$connection = new mysqli($servername, $username, $password, $database);

$errormsg = "";

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $kelas = $_POST['kelas'];

        do {
            if (empty($kelas)) {
                $errormsg = "Harus diisi semua";
                break;
            }

            $sql = "SELECT * FROM dataSiswa WHERE kelas = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $kelas);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
            } else {
                $errormsg = "Gagal mencari siswa: " . $stmt->error;
            }

            $stmt->close();
        } while (false);
    }
} else {
    $sql = "SELECT * FROM dataSiswa";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/dataKelas.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">ADMIN</a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="LoginPage.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
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

    <div class="container-fluid classButton">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-red-800">DATA KELAS</h1>
        </div>
    </div>

    <!-- <div class="container-fluid"></div> -->
    <div class="container my-5 ">
        <form method="POST">
            <div class="mb-3">
                <select class="form-select" aria-label="Default select example" name="kelas">
                    <option selected>Kelas</option>
                    <option value="X MIPA 1">X MIPA 1</option>
                    <option value="X MIPA 2">X MIPA 2</option>
                    <option value="X MIPA 3">X MIPA 3</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary mb-3">Cari Kelas</button>
            <button type="" name="" class="btn btn-success mb-3">Export</button>
            
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Tahun</th>
                        <th>Nama</th>
                        <th>Gender</th>
                        <th>Tempat Tanggal Lahir</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($result)) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['nisn']}</td>
                                <td>{$row['tahun']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['ttl']}</td>
                                <td>{$row['nomor']}</td>
                                <td>{$row['alamat']}</td>
                                <td>{$row['kelas']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <button class='btn btn-sm btn-primary edit-button' data-bs-toggle='modal' data-bs-target='#editStudentModal' data-id='{$row['id']}' data-nisn='{$row['nisn']}' data-tahun='{$row['tahun']}' data-nama='{$row['nama']}' data-gender='{$row['gender']}' data-ttl='{$row['ttl']}' data-nomor='{$row['nomor']}' data-alamat='{$row['alamat']}' data-kelas='{$row['kelas']}' data-status='{$row['status']}'>Edit</button>
                                    <form method='post' class='d-inline'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' name='delete' class='btn btn-sm btn-danger'>Delete</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
