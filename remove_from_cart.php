<?php
session_start();

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Hapus item dengan $book_id dari Cart (unset)
    if (isset($_SESSION['cart'][$book_id])) {
        unset($_SESSION['cart'][$book_id]);
    }

    // Redirect kembali ke halaman Cart atau halaman lain yang sesuai
    header("Location: perpustakaan_view.php");
    exit();
} else {
    // Jika tidak ada parameter 'id', redirect ke halaman lain yang sesuai
    header("Location: some_other_page.php");
    exit();
}
?>
