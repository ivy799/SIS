<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn = $_POST['nisn'];
    $class = $_POST['class'];

    // Fetch additional student data from database if needed
    // Example query (assuming a table named 'students' with relevant columns)
    $sql = "SELECT * FROM students WHERE nisn='$nisn'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Add student to class (assuming a table named 'class_students' with relevant columns)
        $sql = "INSERT INTO class_students (nisn, class) VALUES ('$nisn', '$class')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No student found with NISN: $nisn";
    }
}

$conn->close();
?>

<?php
$koneksi = mysqli_connect("localhost","root", "", "sis");

$nisn = $_POST['nisn'];
$kelas = $_POST['tahun'];
$waliKelas = $_POST['nama'];
$gender = $_POST['gender'];
$ttl = $_POST['ttl'];
$nomor = $_POST['nomor'];
$alamat = $_POST['alamat'];
$kelas = $_POST['kelas'];
$status = $_POST['status'];

$sql = "INSERT INTO dataKelas (nisn, tahun, nama, gender, ttl, nomor, alamat, kelas, status) VALUES ('$nisn', '$tahun', '$nama', '$gender', '$ttl', '$nomor', '$alamat', '$kelas', '$status')";
mysqli_query($koneksi,$sql);
?>
