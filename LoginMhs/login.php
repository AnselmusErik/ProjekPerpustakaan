<?php
// Mulai sesi
session_start();

// Sambungkan ke database Anda di sini
$db = mysqli_connect("localhost", "root", "", "librarydb");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek username di tabel mahasiswa
    $queryMahasiswa = "SELECT * FROM mahasiswa WHERE nama='$username'";
    $resultMahasiswa = mysqli_query($db, $queryMahasiswa);

    // Cek username di tabel admin
    $queryAdmin = "SELECT * FROM admin WHERE admin='$username'";
    $resultAdmin = mysqli_query($db, $queryAdmin);

    if (mysqli_num_rows($resultMahasiswa) > 0) {
        // Jika pengguna adalah mahasiswa
        $mahasiswa = mysqli_fetch_assoc($resultMahasiswa);
        if ($password == $mahasiswa['nim']) {
            // Jika password benar, arahkan ke halaman home mahasiswa
            header('Location: home_mahasiswa.php');
        } else {
            $error = "Username atau password salah";
        }
    } elseif (mysqli_num_rows($resultAdmin) > 0) {
        // Jika pengguna adalah admin
        $admin = mysqli_fetch_assoc($resultAdmin);
        if ($password == $admin['password']) {
            // Jika password benar, arahkan ke halaman home admin
            header('Location: home_admin.php');
        } else {
            $error = "Username atau password salah";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <form action="" method="post">
        <h1>Login Mahasiswa</h1>

        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

        <label for="username">Username : </label>
        <input type="text" name="username" id="username">
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <button type="submit" name="submit">Login</button>

        <!-- Link ke halaman reset password dan register -->
        <div class="link-container">
            <a href="../Reset/reset.php">Forgot Password?</a>
            <!-- <span></span> -->
            <a href="../Register/regis.php">Create Account</a>
        </div>

    </form>
</body>
<script src="login.js"></script>

</html>