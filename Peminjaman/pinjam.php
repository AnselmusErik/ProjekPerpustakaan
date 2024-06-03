<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "librarydb");

$message = '';

if (isset($_POST['submit'])) {
    $nim = $_SESSION['nim'];
    $code_buku = $_POST['code_buku'];
    $tanggal_pinjam = date("Y-m-d");
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $query = "INSERT INTO transaksi_peminjaman (nim, code_buku, tanggal_pinjam, tanggal_kembali, status) VALUES ('$nim', '$code_buku', '$tanggal_pinjam', '$tanggal_kembali', 'dipinjam')";
    $result = mysqli_query($link, $query);

    if ($result) {
        $message = "Peminjaman berhasil dicatat!";
    } else {
        $message = "Terjadi kesalahan: " . mysqli_error($link);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="pinjam.css">
    <title>Pinjam Buku</title>
</head>

<body>
    <?php if ($message) : ?>
        <script>
            window.onload = function() {
                var myModal = new bootstrap.Modal(document.getElementById('messageModal'), {});
                document.getElementById('modalMessage').textContent = '<?php echo $message; ?>';
                myModal.show();
            }
        </script>
    <?php endif; ?>

    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Pemberitahuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalMessage"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post">
        <h1>Pinjam Buku</h1>

        <img src="data:image/png;base64,<?php echo $gambarBase64; ?>" alt="Gambar Buku">
        <p><?php echo $buku['judul_buku']; ?></p>

        <label for="tanggal_kembali">Tanggal Pengembalian:</label>
        <input type="date" name="tanggal_kembali" id="tanggal_kembali" required>

        <input type="hidden" name="code_buku" value="<?php echo $code_buku; ?>">

        <button type="submit" name="submit">Konfirmasi</button>
        <a href="../homeMhs/home.php" class="btn-back btn btn-primary mt-3">Kembali</a>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

<?php
mysqli_close($link);
?>