<?php include "database.php";

date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['id_kendaraan'])) {
    $id_kendaraan = $_POST['id_kendaraan'];
    $jam_keluar     = $_POST['jam_keluar'];
    query("UPDATE tb_kendaraan SET jam_keluar='$jam_keluar',status='Out' WHERE id_kendaraan='$id_kendaraan'");
}

$kendaraan_in = query("SELECT no_kendaraan FROM tb_kendaraan WHERE status='In'");

if (isset($_POST['cari_kendaraan'])) {
    $no_kendaraan     = $_POST['no_kendaraan'];
    $jam_keluar     = $_POST['jam_keluar'];

    $data = query("SELECT * FROM tb_kendaraan WHERE no_kendaraan='$no_kendaraan'");

    $TotalData = hitung($data);

    if ($TotalData == 1) {
        // ada data
        $obj = mysqli_fetch_object($data);
        $tampil = true;

        $jenis_kendaraan = $obj->jenis_kendaraan;



        $lamaparkir = strtotime($jam_keluar) - strtotime($obj->jam_masuk);
        $lamaparkir = ts($lamaparkir);


        // MOTOR 2000/JAM
        // MOBIL 5000/JAM

        // DENDA = LEBIH DARI 3 JAM
        // MOTOR BERUBAH +500
        // MOBIL DITAMBAH +1000 


        if ($jenis_kendaraan == "Motor") {
            $m_denda = 500;
            $m_harga = 2000;
        }

        if ($jenis_kendaraan == "Mobil") {
            $m_denda = 1000;
            $m_harga = 5000;
        }

        $totalharga        = $m_harga * $lamaparkir;
        $denda             = 0;

        if ($lamaparkir > 3) {
            $jam_dendaparkir = $lamaparkir - 3;
            $totalDenda = $jam_dendaparkir * $m_denda;
            $denda = $totalDenda;
            $totalharga     = $totalharga + $totalDenda;
        }


        $totalBayar = $totalharga;
    } else {
        $_SESSION['notif'] = "Tidak ada data ditemukan";
        header("Location: ./keluar.php");
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
            <a href="./">CHECK IN</a>
            <a class="active" href="./keluar.php">CHECK OUT</a>
            <a href="list.php">LIST</a>
        </div>

        <?php if (!isset($tampil)) { ?>
            <form action="" method="POST">

                <?php if (isset($_SESSION['notif'])) { ?>
                    <div class="notif">
                        <p><?= $_SESSION['notif'] ?></p>
                    </div>

                <?php unset($_SESSION['notif']);
                } ?>

                <form action="" method="post">
                    <div class="coolinput">
                        <label for="no_kendaraan" class="text">No Vehicle:</label>
                        <select id="no_kendaraan" name="no_kendaraan" class="input" required>
                        <option value="">Pilih Kendaraan Masuk</option>
                        <?php while ($row = mysqli_fetch_assoc($kendaraan_in)) { ?>
                            <option value="<?= $row['no_kendaraan']; ?>">
                                <?= $row['no_kendaraan']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    </div>

                    <div class="time">
                        <label for="" class="waktu">Time Check Out</label>
                        <input name="jam_keluar" type="time" class="body" value="<?= date('h:i') ?>" required>
                    </div>
                    <input type="hidden" name="cari_kendaraan">
                    <button type="submit">Search Vehicle</button>
                </form>
            <?php } ?>

            <?php if (isset($tampil)) { ?>
                <form action="" method="POST">

                    <div class="coolinput">
                        <label for="" class="text">No Kendaraan</label>
                        <input type="text" disabled value="<?= $obj->no_kendaraan; ?>">

                        <label for="" class="text">Jenis Kendaraan</label>
                        <input type="text" disabled value="<?= $obj->jenis_kendaraan; ?>">

                        <label for="" class="text">Jam Masuk</label>
                        <input type="time" value="<?= $obj->jam_masuk; ?>" disabled>

                        <label for="" class="text">Jam Keluar</label>
                        <input type="time" value="<?= $jam_keluar; ?>" disabled>

                        <input type="hidden" name="jam_keluar" value="<?= $jam_keluar; ?>">

                        <label for="" class="text">Lama Parkir</label>
                        <input type="text" value="<?= ($lamaparkir); ?> Jam">

                        <label for="" class="text">Denda</label>
                        <input type="text" value="<?= $denda; ?>" disabled>

                        <label for="" class="text">Total Harus di bayar</label>
                        <input type="text" value="<?= $totalBayar ?>" disabled>
                        <input type="hidden" name="id_kendaraan" value="<?= $obj->id_kendaraan; ?>">
                    </div>
                    <button>Selesaikan</button>
                </form>
            <?php  } ?>

    </div>
</body>

</html>