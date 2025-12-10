<?php
include "database.php";



date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['submit'])) {
    $no_kendaraan = $_POST['no_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $jam_masuk = $_POST['jam_masuk'];

    $sql = query("INSERT INTO tb_kendaraan (id_kendaraan,no_kendaraan,jenis_kendaraan,jam_masuk,jam_keluar,status) 
    VALUES ('', '$no_kendaraan','$jenis_kendaraan','$jam_masuk','','In')");

    if ($sql) {
        $_SESSION['notif'] = 'Successfully Added';
        header("Location: ./");
        die();
    } else {
        $_SESSION['notif'] = 'Failed to Add';
        header("Location: ./");
        die();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Parkir</title>
    <link rel="stylesheet" href="style1.css?<?= time() ?>">
</head>

<body>
    <div class="container">
        <div class="menu">
            <a class="active" href="./">CHECK IN</a>
            <a href="./keluar.php">CHECK OUT</a>
            <a href="list.php">LIST</a>
        </div>

        <form action="" method="post">

            <?php if (isset($_SESSION['notif'])) { ?>
                <div class="notif">
                    <p><?= $_SESSION['notif'] ?></p>

                </div>

            <?php unset($_SESSION['notif']);
            } ?>


            <div class="coolinput">
                <label for="" class="text">No Vehicle:</label>
                <input type="text" required name="no_kendaraan" class="input">
            </div>

            <div class="radio-input">
                <label>
                    <input value="Motor" name="jenis_kendaraan" id="value-1" type="radio" />
                    <span>Motor</span>
                </label>
                <label>
                    <input value="Mobil" name="jenis_kendaraan" id="value-2" type="radio" />
                    <span>Mobil</span>
                </label>
                <span class="selection"></span>
            </div>


            <div class="time">
                <label for="" class="waktu">Time Check In</label>
                <input name="jam_masuk" type="time" class="body" value="<?= date('h:i') ?>" required>
            </div>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>