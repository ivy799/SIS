<?php

// Create connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "sis";

$connection = new mysqli($servername, $username, $password, $database);
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        // Handle form submission for adding a new student
        $nisn = $_POST['nisn'];
        $tahun = $_POST['tahun'];
        $nama = $_POST['nama'];
        $gender = $_POST['gender'];
        $ttl = $_POST['ttl'];
        $nomor = $_POST['nomor'];
        $alamat = $_POST['alamat'];
        $kelas = $_POST['kelas'];
        $status = $_POST['status'];

        do {
            if (empty($nisn) || empty($tahun) || empty($nama) || empty($gender) || empty($ttl) || empty($nomor) || empty($alamat) || empty($kelas) || empty($status)) {
                $errormsg = "Harus diisi semua";
                break;
            }

            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            $sql = "INSERT INTO dataSiswa (nisn, tahun, nama, gender, ttl, nomor, alamat, kelas, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sssssssss", $nisn, $tahun, $nama, $gender, $ttl, $nomor, $alamat, $kelas, $status);

            if ($stmt->execute()) {
                $nisn = "";
                $tahun = "";
                $nama = "";
                $gender = "";
                $ttl = "";
                $nomor = "";
                $alamat = "";
                $kelas = "";
                $status = "";

                $succesmsg = "Siswa berhasil ditambahkan";
            } else {
                $errormsg = "Gagal menambahkan siswa: " . $stmt->error;
            }

            $stmt->close();
            $connection->close();

        } while (false);
    } elseif (isset($_POST['delete'])) {
        // Handle delete request
        $id = $_POST['id'];

        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        $sql = "DELETE FROM dataSiswa WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $succesmsg = "Siswa berhasil dihapus";
        } else {
            $errormsg = "Gagal menghapus siswa: " . $stmt->error;
        }

        $stmt->close();
        $connection->close();
    } elseif (isset($_POST['edit'])) {
        // Handle edit request
        $id = $_POST['id'];
        $nisn = $_POST['nisn'];
        $tahun = $_POST['tahun'];
        $nama = $_POST['nama'];
        $gender = $_POST['gender'];
        $ttl = $_POST['ttl'];
        $nomor = $_POST['nomor'];
        $alamat = $_POST['alamat'];
        $kelas = $_POST['kelas'];
        $status = $_POST['status'];

        do {
            if (empty($nisn) || empty($tahun) || empty($nama) || empty($gender) || empty($ttl) || empty($nomor) || empty($alamat) || empty($kelas) || empty($status)) {
                $errormsg = "Harus diisi semua";
                break;
            }

            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            $sql = "UPDATE dataSiswa SET nisn = ?, tahun = ?, nama = ?, gender = ?, ttl = ?, nomor = ?, alamat = ?, kelas = ?, status = ? WHERE id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sssssssssi", $nisn, $tahun, $nama, $gender, $ttl, $nomor, $alamat, $kelas, $status, $id);

            if ($stmt->execute()) {
                $succesmsg = "Siswa berhasil diperbarui";
            } else {
                $errormsg = "Gagal memperbarui siswa: " . $stmt->error;
            }

            $stmt->close();
            $connection->close();

        } while (false);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/dataSiswa.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">LOGO</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
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
                <ul class="dropdown-menu dropdown-menu-end">
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
            <a class="dropdown-item" href="DataKelas.php">Data Guru</a>
        </div>
    </div>


    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-black">DATA SISWA</h1>
        </div>
    </div>


    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                        if (!empty($errormsg)) {
                            echo "
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong>$errormsg</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            ";
                        }
                    ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn">
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="tahun" name="tahun">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="laki-laki" value="LAKI-LAKI">
                                <label class="form-check-label" for="laki-laki">LAKI-LAKI</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="perempuan" value="PEREMPUAN">
                                <label class="form-check-label" for="perempuan">PEREMPUAN</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat Tanggal Lahir</label>
                            <input type="text" class="form-control" id="ttl" name="ttl">
                        </div>
                        <div class="mb-3">
                            <label for="nomor" class="form-label">No.HP</label>
                            <input type="text" class="form-control" id="nomor" name="nomor">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="kelas">
                                <option selected>Kelas</option>
                                <option value="X MIPA 1">X MIPA 1</option>
                                <option value="X MIPA 2">X MIPA 2</option>
                                <option value="X MIPA 3">X MIPA 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="lulus" value="LULUS">
                                <label class="form-check-label" for="lulus">LULUS</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="belum-lulus" value="BELUM LULUS">
                                <label class="form-check-label" for="belum-lulus">BELUM LULUS</label>
                            </div>
                        </div>
                        <?php
                            if (!empty($succesmsg)) {
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        <strong>$succesmsg</strong>
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                ";
                            }
                        ?>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                        if (!empty($errormsg)) {
                            echo "
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong>$errormsg</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            ";
                        }
                    ?>
                    <form method="post">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="mb-3">
                            <label for="edit-nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="edit-nisn" name="nisn">
                        </div>
                        <div class="mb-3">
                            <label for="edit-tahun" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="edit-tahun" name="tahun">
                        </div>
                        <div class="mb-3">
                            <label for="edit-nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit-nama" name="nama">
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="edit-laki-laki" value="LAKI-LAKI">
                                <label class="form-check-label" for="edit-laki-laki">LAKI-LAKI</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="edit-perempuan" value="PEREMPUAN">
                                <label class="form-check-label" for="edit-perempuan">PEREMPUAN</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-ttl" class="form-label">Tempat Tanggal Lahir</label>
                            <input type="text" class="form-control" id="edit-ttl" name="ttl">
                        </div>
                        <div class="mb-3">
                            <label for="edit-nomor" class="form-label">No.HP</label>
                            <input type="text" class="form-control" id="edit-nomor" name="nomor">
                        </div>
                        <div class="mb-3">
                            <label for="edit-alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="edit-alamat" name="alamat">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="kelas">
                                <option selected>Kelas</option>
                                <option value="X MIPA 1">X MIPA 1</option>
                                <option value="X MIPA 2">X MIPA 2</option>
                                <option value="X MIPA 3">X MIPA 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="edit-lulus" value="LULUS">
                                <label class="form-check-label" for="edit-lulus">LULUS</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="edit-belum-lulus" value="BELUM LULUS">
                                <label class="form-check-label" for="edit-belum-lulus">BELUM LULUS</label>
                            </div>
                        </div>
                        <?php
                            if (!empty($succesmsg)) {
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        <strong>$succesmsg</strong>
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                ";
                            }
                        ?>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
     <div class="container-fluid">
        <div class="table-responsive">
            <h2>Data Siswa</h2>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal" id="tambahSiswaBtn">Tambah Siswa</button>
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
                    // Create connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "sis";

                    $connection = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                    }

                    $sql = "SELECT * FROM dataSiswa";
                    $result = $connection->query($sql);

                    if (!$result) {
                        die("Invalid query: " . $connection->error);
                    }

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>$row[nisn]</td>
                            <td>$row[tahun]</td>
                            <td>$row[nama]</td>
                            <td>$row[gender]</td>
                            <td>$row[ttl]</td>
                            <td>$row[nomor]</td>
                            <td>$row[alamat]</td>
                            <td>$row[kelas]</td>
                            <td>$row[status]</td>
                            <td>
                                <button class='btn btn-sm btn-primary edit-button' data-bs-toggle='modal' data-bs-target='#editStudentModal' data-id='$row[id]' data-nisn='$row[nisn]' data-tahun='$row[tahun]' data-nama='$row[nama]' data-gender='$row[gender]' data-ttl='$row[ttl]' data-nomor='$row[nomor]' data-alamat='$row[alamat]' data-kelas='$row[kelas]' data-status='$row[status]'>Edit</button>
                                <form method='post' class='d-inline'>
                                    <input type='hidden' name='id' value='$row[id]'>
                                    <button type='submit' name='delete' class='btn btn-sm btn-danger'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }

                    $connection->close();
                    ?>
                </tbody>
            </table>
        </div>
     </div>  
    <script src="dashboard.js"></script>
</body>
</html>
