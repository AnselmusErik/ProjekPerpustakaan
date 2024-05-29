<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="home.css">
    <title>Library</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">Library</a>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <div class="row">
            <?php
            // Koneksi ke database
            $link = mysqli_connect("localhost", "root", "", "librarydb");

            // Query untuk mengambil data buku
            $sql = "SELECT code_buku, judul_buku, gambar, nama_pengarang, penerbit, tahun_terbit FROM buku ORDER BY RAND() LIMIT 3";
            $result = mysqli_query($link, $sql);

            // Tampilkan data buku
            while ($row = mysqli_fetch_assoc($result)) {
                $gambarBase64 = base64_encode($row['gambar']);
                echo '
                <div class="col-md-4">
                    <div class="card">
                        <img src="data:image/png;base64,' . $gambarBase64 . '" class="card-img-top img-fluid" alt="Gambar Buku">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['judul_buku'] . '</h5>
                            <p>ISBN: ' . $row['code_buku'] . '</p>
                            <p>Pengarang: ' . $row['nama_pengarang'] . '</p>
                            <p>Penerbit: ' . $row['penerbit'] . '</p>
                            <p>Tahun Terbit: ' . $row['tahun_terbit'] . '</p>
                            <a href="../Peminjaman/pinjam.php?code_buku=' . $row['code_buku'] . '" class="btn btn-primary btn-pinjam">Pinjam</a>

                        </div>
                    </div>
                </div>';
            }

            // Tutup koneksi
            mysqli_close($link);
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
