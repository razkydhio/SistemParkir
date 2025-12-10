<?php include "database.php";

date_default_timezone_set('Asia/Jakarta');

$table = query("SELECT * FROM tb_kendaraan");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Parkir</title>
    <link rel="stylesheet" href="style1.css?<?= time() ?>">
</head>

<body class="list">
    
    <div class="container container-wide">
        
        <div class="menu">
            <a href="./">CHECK IN</a>
            <a href="./keluar.php">CHECK OUT</a>
            <a class="active" href="list.php">LIST</a>
        </div>

        <?php if (isset($_SESSION['notif'])) { ?>
            <div class="notif">
                <p><?= $_SESSION['notif'] ?></p>
            </div>
        <?php unset($_SESSION['notif']); } ?>
        <table width="100%" border="0" cellspacing="0">
            <thead>
                <tr>
                    <th>No Kendaraan</th>
                    <th>Jenis</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($table as $data) { ?>
                    <tr>
                        <td><?= $data['no_kendaraan'] ?></td>
                        <td><?= $data['jenis_kendaraan'] ?></td>
                        <td><?= $data['jam_masuk'] ?></td>
                        <td><?= $data['jam_keluar'] ?></td>
                        <td>
                            <span class="status-badge <?= strtolower($data['status']); ?>">
                                <?= ucfirst($data['status']); ?>
                            </span>
                        </td>
                        
                        <td align="center">
                            <div class="action-container">
                                <a href="edit.php?id=<?= $data['id_kendaraan'] ?>" class="btn-action btn-edit">Edit</a>
                                
                                <a href="delete.php?id=<?= $data['id_kendaraan'] ?>" 
                                   class="btn-action btn-delete" 
                                   onclick="return confirm('Yakin ingin menghapus data kendaraan <?= $data['no_kendaraan'] ?>?');">
                                   Hapus
                                </a>
                            </div>
                        </td>

                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>