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
            <?php include 'ksidebar.php'; ?>
            <div class="table-container">
                <h1>History</h1>

                <form method="GET" action="">
                    <label for="tanggal">Pilih Tanggal:</label>
                    <select id="tanggal" name="tanggal" onchange="filterByDate()">
                        <option value="">Semua Tanggal</option>
                        <option value="mingguan">Rekap Mingguan</option>
                        <option value="bulanan">Rekap Bulanan</option>
                        <?php
                        // Koneksi database
                        $koneksi = mysqli_connect("localhost", "root", "", "rumahputih");

                        // Check connection
                        if (mysqli_connect_errno()) {
                            echo "Koneksi database gagal : " . mysqli_connect_error();
                        }

                        // Query untuk mendapatkan tanggal unik dari tabel transaksi
                        $tanggalQuery = "SELECT DISTINCT tgl_transaksi FROM transaksi ORDER BY tgl_transaksi ASC";
                        $tanggalResult = $koneksi->query($tanggalQuery);

                        // Loop untuk mengisi opsi select
                        if ($tanggalResult && $tanggalResult->num_rows > 0) {
                            while ($row = $tanggalResult->fetch_assoc()) {
                                $selected = isset($_GET['tanggal']) && $_GET['tanggal'] == $row['tgl_transaksi'] ? 'selected' : '';
                                echo "<option value='" . $row['tgl_transaksi'] . "' $selected>" . $row['tgl_transaksi'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Transaksi</th>
                            <th>Tgl. Transaksi</th>
                            <th>Total</th>
                            <th>Uang Dibayar</th>
                            <th>Kembalian</th>
                            <th>Nama Kasir</th>
                            <th>Nama Pembeli</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $koneksi = mysqli_connect("localhost", "root", "", "rumahputih");

                        // Check connection
                        if (mysqli_connect_errno()) {
                            echo "Koneksi database gagal : " . mysqli_connect_error();
                        }

                        // Mendapatkan pilihan filter
                        $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

                        $no = 1;

                        // Modifikasi query berdasarkan filter (tanggal, mingguan, bulanan)
                        if ($tanggal == 'mingguan') {
                            $query = "SELECT pembeli.nama_pembeli, kasir.username, transaksi.total, transaksi.id_transaksi, transaksi.tgl_transaksi, transaksi.uang_dibayar, transaksi.kembalian
                                      FROM transaksi
                                      JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli
                                      JOIN kasir ON transaksi.id_kasir = kasir.id_kasir
                                      WHERE YEARWEEK(transaksi.tgl_transaksi, 1) = YEARWEEK(CURDATE(), 1)";
                        } elseif ($tanggal == 'bulanan') {
                            $query = "SELECT pembeli.nama_pembeli, kasir.username, transaksi.total, transaksi.id_transaksi, transaksi.tgl_transaksi, transaksi.uang_dibayar, transaksi.kembalian
                                      FROM transaksi
                                      JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli
                                      JOIN kasir ON transaksi.id_kasir = kasir.id_kasir
                                      WHERE MONTH(transaksi.tgl_transaksi) = MONTH(CURDATE()) AND YEAR(transaksi.tgl_transaksi) = YEAR(CURDATE())";
                        } elseif ($tanggal) {
                            $query = "SELECT pembeli.nama_pembeli, kasir.username, transaksi.total, transaksi.id_transaksi, transaksi.tgl_transaksi, transaksi.uang_dibayar, transaksi.kembalian
                                      FROM transaksi
                                      JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli
                                      JOIN kasir ON transaksi.id_kasir = kasir.id_kasir
                                      WHERE transaksi.tgl_transaksi = '$tanggal'";
                        } else {
                            $query = "SELECT pembeli.nama_pembeli, kasir.username, transaksi.total, transaksi.id_transaksi, transaksi.tgl_transaksi, transaksi.uang_dibayar, transaksi.kembalian
                                      FROM transaksi
                                      JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli
                                      JOIN kasir ON transaksi.id_kasir = kasir.id_kasir";
                        }

                        $result = $koneksi->query($query);

                        if ($result && $result->num_rows > 0) {
                            while ($d = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d['id_transaksi']; ?></td>
                                    <td><?php echo $d['tgl_transaksi']; ?></td>
                                    <td><?php echo $d['total']; ?></td>
                                    <td><?php echo $d['uang_dibayar']; ?></td>
                                    <td><?php echo $d['kembalian']; ?></td>
                                    <td><?php echo $d['username']; ?></td>
                                    <td><?php echo $d['nama_pembeli']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function filterByDate() {
            const selectedDate = document.getElementById('tanggal').value;
            const url = new URL(window.location.href);
            if (selectedDate) {
                url.searchParams.set('tanggal', selectedDate);
            } else {
                url.searchParams.delete('tanggal');
            }
            window.location.href = url;
        }
    </script>
</body>

</html>
