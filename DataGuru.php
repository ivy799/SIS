<?php
$nipn = "";
$nama = "";
$gender = "";
$ttl = "";
$nomor = "";
$alamat = "";

$errormsg = "";
$succesmsg = "";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        // Handle form submission for adding a new teacher
        $nipn = $_POST['nipn'];
        $nama = $_POST['nama'];
        $gender = $_POST['gender'];
        $ttl = $_POST['ttl'];
        $nomor = $_POST['nomor'];
        $alamat = $_POST['alamat'];

        do {
            if (empty($nipn) || empty($nama) || empty($gender) || empty($ttl) || empty($nomor) || empty($alamat)) {
                $errormsg = "Harus diisi semua";
                break;
            }

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

            $sql = "INSERT INTO dataguru (nipn, nama, gender, ttl, nomor, alamat) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ssssss", $nipn, $nama, $gender, $ttl, $nomor, $alamat);

            if ($stmt->execute()) {
                $nipn = "";
                $nama = "";
                $gender = "";
                $ttl = "";
                $nomor = "";
                $alamat = "";

                $succesmsg = "Guru berhasil ditambahkan";
            } else {
                $errormsg = "Gagal menambahkan guru: " . $stmt->error;
            }

            $stmt->close();
            $connection->close();

        } while (false);
    } elseif (isset($_POST['delete'])) {
        // Handle delete request
        $id = $_POST['id'];

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

        $sql = "DELETE FROM dataguru WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $succesmsg = "Guru berhasil dihapus";
        } else {
            $errormsg = "Gagal menghapus guru: " . $stmt->error;
        }

        $stmt->close();
        $connection->close();
    } elseif (isset($_POST['edit'])) {
        // Handle edit request
        $id = $_POST['id'];
        $nipn = $_POST['nipn'];
        $nama = $_POST['nama'];
        $gender = $_POST['gender'];
        $ttl = $_POST['ttl'];
        $nomor = $_POST['nomor'];
        $alamat = $_POST['alamat'];

        do {
            if (empty($nipn) || empty($nama) || empty($gender) || empty($ttl) || empty($nomor) || empty($alamat)) {
                $errormsg = "Harus diisi semua";
                break;
            }

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

            $sql = "UPDATE dataguru SET nipn = ?, nama = ?, gender = ?, ttl = ?, nomor = ?, alamat = ? WHERE id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ssssssi", $nipn, $nama, $gender, $ttl, $nomor, $alamat, $id);

            if ($stmt->execute()) {
                $succesmsg = "Guru berhasil diperbarui";
            } else {
                $errormsg = "Gagal memperbarui guru: " . $stmt->error;
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
            <a class="dropdown-item" href="dashboard.php">Dashboard</a>
            <a class="dropdown-item" href="dataSiswa.php">Data Siswa</a>
            <a class="dropdown-item" href="dataKelas.php">Data Kelas</a>
            <a class="dropdown-item" href="dataGuru.php">Data Guru</a>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-black">DATA GURU</h1>
        </div>
    </div>

    <div class="container-fluid mb-3 editButton">
        <div class="d-flex justify-content-start">
          <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addTeacherModal">Tambah Data</button>
            <button type="button" class="btn btn-success">Export Data</button>
        </div>
    </div>

    <!-- Add Teacher Modal -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addTeacherModalTitle">Tambah Data</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post">
              <div class="mb-3">
                <label for="nipn" class="form-label">NIPN</label>
                <input type="text" class="form-control" id="nipn" name="nipn">
              </div>
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama">
              </div>
              <div class="mb-3">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="laki-laki" value="Laki-Laki">
                  <label class="form-check-label" for="laki-laki">LAKI-LAKI</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="perempuan" value="Perempuan">
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
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Teacher Modal -->
    <div class="modal fade" id="editTeacherModal" tabindex="-1" role="dialog" aria-labelledby="editTeacherModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editTeacherModalTitle">Edit Data</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post">
              <input type="hidden" id="edit-id" name="id">
              <div class="mb-3">
                <label for="edit-nipn" class="form-label">NIPN</label>
                <input type="text" class="form-control" id="edit-nipn" name="nipn">
              </div>
              <div class="mb-3">
                <label for="edit-nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="edit-nama" name="nama">
              </div>
              <div class="mb-3">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="edit-laki-laki" value="Laki-Laki">
                  <label class="form-check-label" for="edit-laki-laki">LAKI-LAKI</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="edit-perempuan" value="Perempuan">
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
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="edit" class="btn btn-primary">Edit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">NIPN</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">TTL</th>
                        <th scope="col">No. HP</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Buat koneksi ke database
                    $koneksi = mysqli_connect("localhost", "root", "", "sis");

                    // Periksa koneksi
                    if (!$koneksi) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Ambil data dari tabel guru
                    $sql = "SELECT * FROM dataguru";
                    $result = mysqli_query($koneksi, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // Output data dari setiap row
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $row["id"] . "</th>";
                            echo "<td>" . $row["nipn"] . "</td>";
                            echo "<td>" . $row["nama"] . "</td>";
                            echo "<td>" . $row["gender"] . "</td>";
                            echo "<td>" . $row["ttl"] . "</td>";
                            echo "<td>" . $row["nomor"] . "</td>";
                            echo "<td>" . $row["alamat"] . "</td>";
                            echo "<td>
                                <button class='btn btn-sm btn-primary edit-button' data-bs-toggle='modal' data-bs-target='#editTeacherModal' data-id='" . $row["id"] . "' data-nipn='" . $row["nipn"] . "' data-nama='" . $row["nama"] . "' data-gender='" . $row["gender"] . "' data-ttl='" . $row["ttl"] . "' data-nomor='" . $row["nomor"] . "' data-alamat='" . $row["alamat"] . "'>Edit</button>
                                <form method='post' class='d-inline'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <button type='submit' name='delete' class='btn btn-sm btn-danger'>Delete</button>
                                </form>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No data found</td></tr>";
                    }

                    mysqli_close($koneksi);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Populate edit modal with teacher data
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', event => {
                const id = event.currentTarget.getAttribute('data-id');
                const nipn = event.currentTarget.getAttribute('data-nipn');
                const nama = event.currentTarget.getAttribute('data-nama');
                const gender = event.currentTarget.getAttribute('data-gender');
                const ttl = event.currentTarget.getAttribute('data-ttl');
                const nomor = event.currentTarget.getAttribute('data-nomor');
                const alamat = event.currentTarget.getAttribute('data-alamat');

                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nipn').value = nipn;
                document.getElementById('edit-nama').value = nama;
                document.querySelector(`input[name="gender"][value="${gender}"]`).checked = true;
                document.getElementById('edit-ttl').value = ttl;
                document.getElementById('edit-nomor').value = nomor;
                document.getElementById('edit-alamat').value = alamat;
            });
        });
    </script>
</body>
</html>
