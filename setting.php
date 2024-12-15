<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Setting</title>
  <link rel="stylesheet" href="css/editKP.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<style>
  * {
    margin: 0;
    padding: 0;
  }

  body {
    background-color: #dde9dd;
  }

  .big-three {
    display: flex;
    justify-content: flex-start;
  }

  .side-bar {
    display: inline;
    position: fixed;
    height: 100%;
    width: 200px;
    background-color: #ffff;
    border-right: 1px solid #979494;
    left: 0;
  }

  .side-bar img {
    width: 150px;
    margin: 20px;
  }

  .side-bar-item {
    margin-top: 5px;
    margin-bottom: 30px;
    margin-left: 20px;
  }

  .side-bar-item:hover a {
    color: #9cc1e5;
  }

  .side-bar-item a {
    text-decoration: none;
    color: black;
  }

  .side-bar-item a i {
    margin-right: 10px;
  }

  .log-out {
    margin-top: 170px;
    margin-left: 20px;
  }

  .log-out:hover a {
    color: #9cc1e5;
  }

  .log-out a {
    text-decoration: none;
    color: black;
  }

  .log-out a i {
    margin-right: 10px;
  }

  .button {
    margin-left: 635px;
    margin-top: 250px;
  }

  .edit-button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 150px;
    padding: 10px;
    background-color: #9cc1e5;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    color: black;
    cursor: pointer;
    text-decoration: none;
  }

  .edit-button:hover a {
    color: #4a97e4;
  }

  .edit-button a {
    text-decoration: none;
    color: black;
  }

  .tabel table {
    width: 1100px;
    border-collapse: collapse;
    margin-left: 250px;
    margin-top: 20px;
  }

  .tabel th,
  .tabel td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
  }

  .tabel th {
    background-color: #41729F;
    color: white;
  }

  .tabel tr:hover {
    background-color: #e6f7ff;
  }

  .tabel a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #41729F;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
  }

  .tabel a:hover {
    background-color: #9cc1e5;
    color: white;
  }

  .tabel td a {
    display: inline-block;
    margin-right: 10px;
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: white;
    text-decoration: none;
  }

  .tabel td a:hover {
    background-color: #9cc1e5;
    border-color: #769dc6;
    color: white;
  }
</style>

<body>
  <div class="container">
    <div class="big-three">
      <?php include 'sidebar.php'; ?>
    </div>

    <div class="tabel">
      <table border="1">
        <tr style="width:100%">
          <th>Id</th>
          <th>Nama</th>
          <th>No HP</th>
          <th>Aksi</th>
        </tr>
        <?php
        include 'konek.php';
        $no = 1;

        $result = $conn->query("SELECT * FROM kasir");

        if ($result) {
          while ($d = $result->fetch_assoc()) {
        ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo htmlspecialchars($d['username']); ?></td>
              <td><?php echo htmlspecialchars($d['no_telp']); ?></td>
              <td>
                <a href="editkasir.php?id_kasir=<?php echo $d['id_kasir']; ?>">EDIT</a>
                <a href="hapuskasir.php?id=<?php echo $d['id_kasir']; ?>"
                  onclick="return confirm('Apakah Anda yakin ingin menghapus kasir ini?')">
                  HAPUS
                </a>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td colspan='4'>Tidak ada data kasir.</td></tr>";
        }
        ?>
      </table>
      <br>
      <a href="sign-up.html" style="margin-left: 1180px;width:130px;color:white;">TAMBAH KASIR</a>
    </div>
  </div>
</body>

</html>