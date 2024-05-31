<?php
session_start();

// Koneksi ke database
$link = mysqli_connect("localhost", "root", "", "librarydb");

if (!$link) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Ambil data transaksi dari database
$query = "SELECT tp.nim, m.nama, tp.code_buku, b.judul_buku, tp.tanggal_pinjam, tp.tanggal_kembali, tp.status 
          FROM transaksi_peminjaman tp 
          JOIN mahasiswa m ON tp.nim = m.nim 
          JOIN buku b ON tp.code_buku = b.code_buku";
$result = mysqli_query($link, $query);
    
if (!$result) {
    die("Query gagal: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="transaksi.css">
    <title>Daftar Transaksi Peminjaman</title>
</head>

<body>
    <div class="container">
        <h1>Daftar Transaksi Peminjaman</h1>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['nim']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['code_buku']; ?></td>
                        <td><?php echo $row['judul_buku']; ?></td>
                        <td><?php echo $row['tanggal_pinjam']; ?></td>
                        <td><?php echo $row['tanggal_kembali']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="../homeMhs/home.php" class="btn-back">Kembali</a>
    </div>
</body>

</html>

<?php
mysqli_close($link);
?>
