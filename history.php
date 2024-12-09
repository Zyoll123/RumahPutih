<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="css/history.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="big-three">
        <?php include 'sidebar.php';?>
            <div class="table-container">
                <h1>History</h1>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Transaksi</th>
                            <th>Tgl.Transaksi</th>
                            <th>Total</th>
                            <th>Nama Kasir</th>
                            <th>Nama Pembeli</th>
                            <th>Metode Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $koneksi = mysqli_connect("localhost", "root", "", "rumahputih");

                        // Check connection
                        if (mysqli_connect_errno()) {
                            echo "Koneksi database gagal : " . mysqli_connect_error();
                        }
                        ?>
                        <?php
                        $no = 1;
                        $result = $koneksi->query("SELECT pembeli.nama_pembeli, kasir.username, payment.nama_metode, transaksi.total, transaksi.id_transaksi, transaksi.tgl_transaksi
                        FROM transaksi
                        JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli
                        JOIN kasir ON transaksi.id_kasir = kasir.id_kasir
                        JOIN payment ON transaksi.id_payment = payment.id_payment");
                        if ($result) {
                            while ($d = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d['id_transaksi']; ?></td>
                                    <td><?php echo $d['tgl_transaksi']; ?></td>
                                    <td><?php echo $d['total']; ?></td>
                                    <td><?php echo $d['username']; ?></td>
                                    <td><?php echo $d['nama_pembeli']; ?></td>
                                    <td><?php echo $d['nama_metode']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>