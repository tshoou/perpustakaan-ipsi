<?php
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Koneksi ke database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "perpustakaan";
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Hapus buku dari database berdasarkan ID buku
    $sql = "DELETE FROM Buku WHERE id_buku = $book_id";
    if ($conn->query($sql) === TRUE) {
        echo "Buku berhasil dihapus.";
    } else {
        echo "Error: " . $conn->error;
    }

    // Tutup koneksi
    $conn->close();

    // Redirect kembali ke halaman "program_perpustakaan.html" atau halaman lain yang sesuai
    header("Location: perpustakaan_view.php");
    exit();
} else {
    // Jika tidak ada parameter 'id', redirect ke halaman lain yang sesuai
    header("Location: some_other_page.php");
    exit();
}
?>
