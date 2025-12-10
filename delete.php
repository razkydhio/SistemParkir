<?php
include "database.php";

// Cek apakah ada id yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query hapus data
    $sql = query("DELETE FROM tb_kendaraan WHERE id_kendaraan = '$id'");

    if ($sql) {
        // Set session notif sukses
        $_SESSION['notif'] = "Data Berhasil Dihapus";
        header("Location: list.php");
        die();
    } else {
        // Set session notif gagal
        $_SESSION['notif'] = "Data Gagal Dihapus";
        header("Location: list.php");
        die();
    }
} else {
    // Jika tidak ada id, kembalikan ke list
    header("Location: list.php");
    die();
}
?>