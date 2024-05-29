<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "librarydb");

if (isset($_POST['submit'])) {
    $nim = $_SESSION['nim'];
    $code_buku = $_POST['code_buku'];
    $tanggal_pinjam = date("Y-m-d");
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $query = "INSERT INTO transaksi_peminjaman (nim, code_buku, tanggal_pinjam, tanggal_kembali, status) VALUES ('$nim', '$code_buku', '$tanggal_pinjam', '$tanggal_kembali', 'dipinjam')";
    $result = mysqli_query($link, $query);

    if ($result) {
        echo "Peminjaman berhasil dicatat!";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($link);
    }
}

$code_buku = $_GET['code_buku'];
$query = "SELECT * FROM buku WHERE code_buku='$code_buku'";
$result = mysqli_query($link, $query);
$buku = mysqli_fetch_assoc($result);
$gambarBase64 = base64_encode($buku['gambar']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pinjam.css">
    <title>Pinjam Buku</title>
</head>

<body>
    <form action="" method="post">
        <h1>Pinjam Buku</h1>

        <img src="data:image/png;base64,<?php echo $gambarBase64; ?>" alt="Gambar Buku">
        <p><?php echo $buku['judul_buku']; ?></p>

        <label for="tanggal_kembali">Tanggal Pengembalian:</label>
        <input type="date" name="tanggal_kembali" id="tanggal_kembali" required>

        <input type="hidden" name="code_buku" value="<?php echo $code_buku; ?>">

        <button type="submit" name="submit">Konfirmasi</button>
    </form>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            var tanggalKembali = document.querySelector('#tanggal_kembali').value;
            if (!tanggalKembali) {
                e.preventDefault();
                alert('Harap isi tanggal kembali!');
            }
        });
    </script>
</body>

</html>