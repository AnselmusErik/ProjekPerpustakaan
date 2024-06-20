
// // Ambil data buku dari PHP ke dalam JavaScript
// // const allBooks = <?php echo $filteredBooksJson; ?>;
// // Ambil data buku dari PHP ke dalam JavaScript
// const allBooks = <?php echo json_encode($filteredBooksJson); ?>;


// // Pagination settings
// const booksPerPage = 6;
// let currentPage = 1;

// // Fungsi untuk menampilkan buku berdasarkan halaman
// function displayBooks(books, page) {
//     const bookContainer = document.getElementById('bookContainer');
//     bookContainer.innerHTML = '';
//     const startIndex = (page - 1) * booksPerPage;
//     const endIndex = startIndex + booksPerPage;
//     const paginatedBooks = books.slice(startIndex, endIndex);

//     paginatedBooks.forEach(book => {
//         bookContainer.innerHTML += `
// <div class="col-md-4 mb-4">
//     <div class="card h-100">
//         <img src="data:image/png;base64,${book.gambar}" class="card-img-top img-fluid" alt="Gambar Buku">
//         <div class="card-body">
//             <h5 class="card-title">${book.judul_buku}</h5>
//             <p>ISBN: ${book.code_buku}</p>
//             <p>Pengarang: ${book.nama_pengarang}</p>
//             <p>Penerbit: ${book.penerbit}</p>
//             <p>Tahun Terbit: ${book.tahun_terbit}</p>
//             <a href="../Peminjaman/pinjam.php?code_buku=${book.code_buku}" class="btn btn-primary btn-pinjam">Pinjam</a>
//         </div>
//     </div>
// </div>`;
//     });
// }

// // Fungsi untuk menampilkan pagination dengan ikon panah
// function displayPagination(books, page) {
//     const pagination = document.getElementById('pagination');
//     pagination.innerHTML = '';
//     const totalPages = Math.ceil(books.length / booksPerPage);

//     // Tombol Previous
//     pagination.innerHTML += `
//     <li class="page-item ${page === 1 ? 'disabled' : ''}">
//         <a class="page-link" href="#" onclick="changePage(${page - 1})">
//             <span>&laquo;</span>
//         </a>
//     </li>
// `;

//     // Tombol-tombol halaman
//     for (let i = 1; i <= totalPages; i++) {
//         pagination.innerHTML += `
//         <li class="page-item ${i === page ? 'active' : ''}">
//             <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
//         </li>`;
//     }

//     // Tombol Next
//     pagination.innerHTML += `
//     <li class="page-item ${page === totalPages ? 'disabled' : ''}">
//         <a class="page-link" href="#" onclick="changePage(${page + 1})">
//             <span>&raquo;</span>
//         </a>
//     </li>
// `;
// }

// // Fungsi untuk mengganti halaman
// function changePage(page) {
//     currentPage = page;
//     displayBooks(allBooks, page);
//     displayPagination(allBooks, page);
// }

// // Fungsi untuk mencari buku
// function searchBooks(event) {
//     event.preventDefault();
//     const searchQuery = document.getElementById('searchInput').value.toLowerCase();
//     window.location.href = `?search=${searchQuery}`;
// }

// // Display initial books
// displayBooks(allBooks, currentPage);
// displayPagination(allBooks, currentPage);
