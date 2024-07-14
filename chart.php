<?php
// Koneksi ke database MySQL
$mysqli = new mysqli("localhost", "username", "password", "sis");

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

<script>
    // Memasukkan data JSON ke dalam JavaScript
    var arrayObjects = <?php echo $json_array; ?>;
</script>
