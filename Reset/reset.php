<?php
// Mulai sesi
session_start();

// Sambungkan ke database Anda di sini
$db = new mysqli("localhost", "root", "", "librarydb");

// Cek koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];

    // Query untuk mencari mahasiswa dengan username dan password lama yang sesuai
    $query = $db->prepare("SELECT * FROM mahasiswa WHERE nama = ? AND nim = ?");
    $query->bind_param("ss", $username, $old_password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Jika mahasiswa ditemukan dan password lama benar, update password
        $update_query = $db->prepare("UPDATE mahasiswa SET nim = ? WHERE nama = ?");
        $update_query->bind_param("ss", $new_password, $username);
        $result = $update_query->execute();
        
        if ($result) {
            $success = "Password berhasil direset!";
            // Alihkan ke halaman login setelah 2 detik
            header("refresh:2; url=../LoginMhs/login.php");
        } else {
            $error = "Gagal mereset password!";
        }
    } else {
        $error = "Username atau password lama salah!";
    }

    $query->close();
    $update_query->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Mahasiswa</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <form method="post" id="resetForm">
        <h1>Reset Password</h1>

        <?php if (isset($error)) : ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <label for="username">Username : </label>
        <input type="text" name="username" id="username" required>
        <label for="old_password">Old Password : </label>
        <input type="password" name="old_password" id="old_password" required>
        <label for="new_password">New Password : </label>
        <input type="password" name="new_password" id="new_password" required>
        <button type="submit" name="submit">Reset Password</button>

        <!-- untuk membuat link dengan ikon -->
        <a href="../LoginMhs/login.php" style="display: block; margin-top: 5px; margin-left: 175px;">
            <i class="fas fa-arrow-left"></i></a>
    </form>
</body>
<script src="reset.js"></script>
</html>
