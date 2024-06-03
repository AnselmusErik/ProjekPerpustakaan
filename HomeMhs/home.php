<?php
// Koneksi ke database
$link = mysqli_connect("localhost", "root", "", "librarydb");

// Fungsi untuk memeriksa substring menggunakan backtracking
function isSubstringBacktracking($str, $substr)
{
    $lenStr = strlen($str);
    $lenSubstr = strlen($substr);

    for ($i = 0; $i <= $lenStr - $lenSubstr; $i++) {
        if (isMatch($str, $substr, $i, 0)) {
            return true;
        }
    }
    return false;
}

function isMatch($str, $substr, $i, $j)
{
    if ($j == strlen($substr)) {
        return true;
    }
    if ($i >= strlen($str) || $str[$i] != $substr[$j]) {
        return false;
    }
    return isMatch($str, $substr, $i + 1, $j + 1);
}

// Query untuk mengambil semua buku untuk pencarian
$sql_all = "SELECT code_buku, judul_buku, gambar, nama_pengarang, penerbit, tahun_terbit FROM buku";
$result_all = mysqli_query($link, $sql_all);

$allBooks = [];
while ($row = mysqli_fetch_assoc($result_all)) {
    $row['gambar'] = base64_encode($row['gambar']);
    $allBooks[] = $row;
}

// Fungsi untuk mencari buku berdasarkan judul menggunakan backtracking
function searchBooksBacktracking($books, $query)
{
    $result = [];
    foreach ($books as $book) {
        if (isSubstringBacktracking(strtolower($book['judul_buku']), strtolower($query))) {
            $result[] = $book;
        }
    }
    return $result;
}

// Proses pencarian jika ada query pencarian
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$filteredBooks = $searchQuery ? searchBooksBacktracking($allBooks, $searchQuery) : $allBooks;

// Encode data buku ke JSON
$filteredBooksJson = json_encode($filteredBooks);

// Tutup koneksi
mysqli_close($link);
?>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../Transaksi/transaksi.php">Daftar Peminjaman</a>
                    </li>
                </ul>
                <form class="d-flex" id="searchForm" role="search" onsubmit="searchBooks(event)">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Content -->
    <div class="container mt-5">
        <div class="row" id="bookContainer"></div>
        <nav>
            <ul class="pagination" id="pagination"></ul>
        </nav>
    </div>
    <script>
        // Ambil data buku dari PHP ke dalam JavaScript
        const allBooks = <?php echo $filteredBooksJson; ?>;

        // Pagination settings
        const booksPerPage = 6;
        let currentPage = 1;

        // Fungsi untuk menampilkan buku berdasarkan halaman
        function displayBooks(books, page) {
            const bookContainer = document.getElementById('bookContainer');
            bookContainer.innerHTML = '';
            const startIndex = (page - 1) * booksPerPage;
            const endIndex = startIndex + booksPerPage;
            const paginatedBooks = books.slice(startIndex, endIndex);

            paginatedBooks.forEach(book => {
                bookContainer.innerHTML += `
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="data:image/png;base64,${book.gambar}" class="card-img-top img-fluid" alt="Gambar Buku">
                    <div class="card-body">
                        <h5 class="card-title">${book.judul_buku}</h5>
                        <p>ISBN: ${book.code_buku}</p>
                        <p>Pengarang: ${book.nama_pengarang}</p>
                        <p>Penerbit: ${book.penerbit}</p>
                        <p>Tahun Terbit: ${book.tahun_terbit}</p>
                        <a href="../Peminjaman/pinjam.php?code_buku=${book.code_buku}" class="btn btn-primary btn-pinjam">Pinjam</a>
                    </div>
                </div>
            </div>`;
            });
        }

        // Fungsi untuk menampilkan pagination dengan ikon panah
        function displayPagination(books, page) {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            const totalPages = Math.ceil(books.length / booksPerPage);

            // Tombol Previous
            pagination.innerHTML += `
            <li class="page-item ${page === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${page - 1})">
                    <span>&laquo;</span>
                </a>
            </li>
        `;

            // Tombol-tombol halaman
            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                <li class="page-item ${i === page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                    </li>`;
            }

            // Tombol Next
            pagination.innerHTML += `
            <li class="page-item ${page === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${page + 1})">
                    <span>&raquo;</span>
                </a>
            </li>
        `;
        }

        // Fungsi untuk mengganti halaman
        function changePage(page) {
            currentPage = page;
            displayBooks(allBooks, page);
            displayPagination(allBooks, page);
        }

        // Fungsi untuk mencari buku
        function searchBooks(event) {
            event.preventDefault();
            const searchQuery = document.getElementById('searchInput').value.toLowerCase();
            window.location.href = `home.php?search=${searchQuery}`;
        }

        // Display initial books
        displayBooks(allBooks, currentPage);
        displayPagination(allBooks, currentPage);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>