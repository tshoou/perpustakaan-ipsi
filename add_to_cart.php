<?php
session_start();

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Tambahkan buku ke dalam Cart (Anda perlu mengimplementasikan logika penyimpanan Cart sesuai kebutuhan)
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (!isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id] = 1;
    } else {
        $_SESSION['cart'][$book_id]++;
    }

    header("Location: perpustakaan_view.php");
    exit();
}
?>
