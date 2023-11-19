<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Program Perpustakaan</title>
</head>
<body>
<div id='navbar'>
        <h1>Program Perpustakaan</h1>
        <form method="get" action="search.php">
            <label for="search">Cari Buku:</label>
            <input type="text" id="search" name="search">
            <input type="submit" value="Cari">
        </form>
    </div>
    <div id='table-buku'>
    <h3>Data Buku</h3>
    <table border="1">
        <tr>
            <th>ID Buku</th>
            <th>Judul Buku</th>
            <th>Pengarang</th>
            <th>Tahun Terbit</th>
            <th>Penerbit</th>
            <th>Stok Buku</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
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

        if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_buku'] . "</td>";
                echo "<td>" . $row['judulBuku'] . "</td>";
                echo "<td>" . $row['pengarang'] . "</td>";
                echo "<td>" . $row['tahunTerbit'] . "</td>";
                echo "<td>" . $row['penerbit'] . "</td>";
                echo "<td>" . $row['stokBuku'] . "</td>";
                echo "<td>" . $row['deskripsi'] . "</td>";
                echo "<td><a id='add-cart-button' href='add_to_cart.php?id=" . $row['id_buku'] . "' >Tambah ke Cart</a>
                <a id='delete-cart-button' href='remove_from_book.php?id=" . $row['id_buku'] . "'>Hapus Buku</a>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada buku yang tersedia.</td></tr>";
        }

        // Tutup koneksi
        $conn->close();
        ?>
    </table>    
    </div>

    <!-- Menampilkan Isi Cart -->
    <div id = "table-buku">
    <h3>Isi Cart</h3>
    <table border="1" style="margin-bottom: 24px">
    <tr>
        <th>Judul Buku</th>
        <th>Jumlah</th>
        <th>Aksi</th>
    </tr>
    <?php
    session_start();

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<tr><td colspan='4'>Cart kosong.</td></tr>";
    } else {
        // Koneksi ke database
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "perpustakaan";
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        foreach ($_SESSION['cart'] as $book_id => $quantity) {
            // Mengambil informasi buku dari database berdasarkan $book_id
            $sql = "SELECT * FROM Buku WHERE id_buku = $book_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<tr>";
                echo "<td>" . $row['judulBuku'] . "</td>";
                echo "<td>" . $quantity . "</td>";
                echo "<td><a id='delete-cart-button' href='remove_from_cart.php?id=" . $row['id_buku'] . "'>Hapus</a></td>";
                echo "</tr>";
            }
        }

        // Tutup koneksi
        $conn->close();
    }
    ?>
</table>
    </div>
<footer>
    <h4>Copyright &copy; IPSI</h4>
</footer>
</body>
</html>
