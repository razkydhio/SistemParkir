<?php
include "database.php";
date_default_timezone_set('Asia/Jakarta');

//ambil ID untuk pengecekan ID agar tidak error jika diakses langsung
if (!isset($_GET['id'])) {
    header("Location: list.php");
    die();
}

$id = $_GET['id'];

//Ambil data kendaraan berdasarkan ID untuk ditampilkan di form
$data = query("SELECT * FROM tb_kendaraan WHERE id_kendaraan = '$id'");
$kendaraan = mysqli_fetch_assoc($data);

//Cek apakah tombol update ditekan
if (isset($_POST['update'])) {
    $id_kendaraan = $_POST['id_kendaraan'];
    $no_kendaraan = $_POST['no_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $jam_masuk = $_POST['jam_masuk']; 

    $sql = query("UPDATE tb_kendaraan SET 
                    no_kendaraan = '$no_kendaraan',
                    jenis_kendaraan = '$jenis_kendaraan',
                    jam_masuk = '$jam_masuk'
                  WHERE id_kendaraan = '$id_kendaraan'");

    if ($sql) {
        $_SESSION['notif'] = "Data Berhasil Diubah";
        header("Location: list.php");
        die();
    } else {
        $_SESSION['notif'] = "Gagal Mengubah Data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Parkir</title>
    <link rel="stylesheet" href="style1.css?<?= time() ?>">
</head>
<body>
    <div class="container">
        <div class="menu">
            <a href="./">CHECK IN</a>
            <a href="./keluar.php">CHECK OUT</a>
            <a href="list.php">LIST</a>
        </div>

        <h3 style="text-align:center; color:#fff; margin-bottom:20px; font-weight:600;">Edit Kendaraan</h3>

        <?php if (isset($_SESSION['notif'])) { ?>
            <div class="notif" style="background-color: #ef4444;"> <p><?= $_SESSION['notif'] ?></p>
            </div>
        <?php unset($_SESSION['notif']); } ?>


        <form action="" method="post">
            <input type="hidden" name="id_kendaraan" value="<?= $kendaraan['id_kendaraan'] ?>">

            <div class="coolinput">
                <label for="" class="text">No Vehicle:</label>
                <input type="text" required name="no_kendaraan" class="input" value="<?= $kendaraan['no_kendaraan'] ?>">
            </div>

            <div class="radio-input">
                <label>
                    <input value="Motor" name="jenis_kendaraan" type="radio" <?= ($kendaraan['jenis_kendaraan'] == 'Motor') ? 'checked' : '' ?> />
                    <span>Motor</span>
                </label>
                <label>
                    <input value="Mobil" name="jenis_kendaraan" type="radio" <?= ($kendaraan['jenis_kendaraan'] == 'Mobil') ? 'checked' : '' ?> />
                    <span>Mobil</span>
                </label>
                <span class="selection"></span>
            </div>

            <div class="time">
                <label for="" class="waktu">Time Check In</label>
                <input name="jam_masuk" type="time" class="body" value="<?= $kendaraan['jam_masuk'] ?>" required>
            </div>
            
            <button type="submit" name="update" style="background-color: #f59e0b;">Update Data</button>
            
            <a href="list.php" style="display:block; text-align:center; margin-top:15px; text-decoration:none; color: rgba(255,255,255,0.7); font-size: 14px;">Batal & Kembali</a>
        </form>
    </div>
</body>
</html>