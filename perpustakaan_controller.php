<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "perpustakaan";
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari tabel Buku
$sql = "SELECT * FROM Buku";
$result = $conn->query($sql);

$buku = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $buku[] = $row;
    }
}

// Tutup koneksi
$conn->close();

// Menampilkan tampilan (view)
include('perpustakaan_view.php');
?>
