<?php
session_start();

$koneksi = mysqli_connect("localhost", "root", "", "azizah_27");

// Cek koneksi
if (mysqli_connect_errno()){
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['nama'];
    $password = $_POST['password'];
    $login_as = $_POST['login_as'];

    if ($login_as === 'admin') {
        $stmt = $koneksi->prepare("SELECT * FROM admin WHERE nama = ? AND password = ?");
    } else {
        $stmt = $koneksi->prepare("SELECT * FROM user WHERE nama = ? AND password = ?");
    }

    $stmt->bind_param("ss", $username, $password);
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }

    $result = $stmt->get_result();

    // Cek apakah user ditemukan
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];

        if ($login_as === 'admin') {
            header("Location: azizah_27.php");
        } else {
            header("Location: user.php");
        }
        exit();
    } else {
        echo "Username atau password salah.";
        exit();
    }

    $stmt->close();
}

$koneksi->close();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LOGIN</title>
    <style>
        body {
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1, p {
            text-align: center;
            font-size: x-large;
        }
        .log {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
            text-align: center;
        }
        .log input, .log select {
            width: 100%;
            height: 40px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .log button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .log button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1>SELAMAT DATANG DI WEB DATA DIRI</h1>
    <div class="log">
        <form action="" method="POST">
            <p>Silahkan Login Terlebih Dahulu</p>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <input type="text" name="nama" placeholder="Masukkan Nama" required>
            <input type="password" name="password" placeholder="Masukkan Password" required>
            <select name="login_as" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <br><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
