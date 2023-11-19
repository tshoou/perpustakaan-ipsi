<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Program Perpustakaan</title>
</head>

<body>
    <div id="navbar" style="background-color :#d31212">
        <h1>Program Perpustakaan</h1>
        <form method="get" action="search.php">
            <label for="search">Cari Buku:</label>
            <input type="text" id="search" name="search">
            <input type="submit" value="Cari">
        </form>
    </div>
    <table border="1">
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

        // Mengambil kata kunci pencarian dari parameter GET
        if (isset($_GET['search'])) {
            $search_keyword = $_GET['search'];

            // Menggunakan prepared statement untuk mencegah SQL injection
            $sql = "SELECT * FROM Buku WHERE judulBuku LIKE ?";
            $stmt = $conn->prepare($sql);
            $search_param = "%" . $search_keyword . "%";
            $stmt->bind_param("s", $search_param);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>ID Buku</th>";
                echo "<th>Judul Buku</th>";
                echo "<th>Pengarang</th>";
                echo "<th>Tahun Terbit</th>";
                echo "<th>Penerbit</th>";
                echo "<th>Stok Buku</th>";
                echo "<th>Deskripsi</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_buku'] . "</td>";
                    echo "<td>" . $row['judulBuku'] . "</td>";
                    echo "<td>" . $row['pengarang'] . "</td>";
                    echo "<td>" . $row['tahunTerbit'] . "</td>";
                    echo "<td>" . $row['penerbit'] . "</td>";
                    echo "<td>" . $row['stokBuku'] . "</td>";
                    echo "<td>" . $row['deskripsi'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "Tidak ditemukan buku dengan kata kunci '" . $search_keyword . "'.";
            }

            $stmt->close();
        } else {
            echo "Masukkan kata kunci pencarian.";
        }

        // Tutup koneksi
        $conn->close();
        ?>
    </table>

    <!-- Menampilkan Isi Cart -->
    <h2>Isi Cart</h2>
    <table border="1">
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
                    echo "<td><a href='remove_from_cart.php?id=" . $row['id_buku'] . "'>Hapus</a></td>";
                    echo "</tr>";
                }
            }

            // Tutup koneksi
            $conn->close();
        }
        ?>
    </table>
</body>

</html>