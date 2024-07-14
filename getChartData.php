<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sis";

// Tangkap error dan tampilkan dalam format JSON
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connection = new mysqli($servername, $username, $password, $database);
    $connection->set_charset("utf8mb4");

    // Query to get data for chart
    $query = "SELECT YEAR(tanggalMasuk) as tahun, COUNT(*) as total FROM dataSiswa WHERE status = 'LULUS' GROUP BY YEAR(tanggalMasuk)";
    $result = $connection->query($query);

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    $connection->close();
}
?>
