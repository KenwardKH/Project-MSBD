<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Produk</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/owner_nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner_product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-pagination.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        button,
        input,
        optgroup,
        select,
        textarea {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            font-size: medium;
            line-height: normal;
        }

        .btn-link:hover {
            color: #80f4ac;
        }

        .bg-warning {
            background-color: #fff3cd !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="logo" class="logo">
            <div class="nav">
                <div class="left">
                    <a href="{{ route('owner.home') }}">Home</a>
                </div>
                <div class="right">
                    <a href="{{ route('owner.product') }}">Produk <i class="bi bi-box-seam"></i></a>
                    <a href="{{ route('owner.daftar-supplier') }}">Supplier<i class="bi bi-shop"></i></a>
                    <a href="{{ route('owner.daftarSupply') }}">Riwayat Pembelian Supply <i
                            class="bi bi-bag-plus"></i></a>
                    <a href="{{ route('owner.daftar-costumer') }}">User<i class="bi bi-person"></i></a>
                    <a href="{{ route('owner.riwayatTransaksi') }}">Riwayat Transaksi <i
                            class="bi bi-receipt-cutoff"></i></a>
                    <a href="{{ route('owner.laporanPenjualan') }}">Laporan Penjualan<i
                            class="bi bi-journal-text"></i></a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-link"
                            style="background: none; border: none; padding: 0; margin: 0; cursor: pointer;">
                            <a>Keluar <i class="bi bi-box-arrow-right"></i></a>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="dashboard">
            <h1 style="font-weight: bold">Stock Barang</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Bar -->
            <div class="search-container">
                <form action="{{ route('owner.product') }}" method="GET">
                    <input type="text" name="query" placeholder="Cari..." class="search-input"
                        style="width: 200px;" value="{{ request('query') }}">
                    <button type="submit" class="search-button">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <div style="display: flex; justify-content:right; margin:10px ;margin-right:30px">
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    + Tambah Produk
                </button>
            </div>

            <!-- Modal for Adding Product -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('owner.store-product') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProductLabel">Tambah Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Product Name -->
                                <div class="form-group">
                                    <label for="ProductName">Nama Produk</label>
                                    <input type="text" id="ProductName" name="ProductName" class="form-control"
                                        required>
                                </div>

                                <!-- Selling Price -->
                                <div class="form-group mt-3">
                                    <label for="UnitPrice">Harga Jual</label>
                                    <input type="number" id="UnitPrice" name="UnitPrice" class="form-control" required>
                                </div>

                                <!-- Product Unit -->
                                <div class="form-group mt-3">
                                    <label for="ProductUnit">Satuan</label>
                                    <input type="text" id="ProductUnit" name="ProductUnit" class="form-control"
                                        required>
                                </div>

                                <!-- Description -->
                                <div class="form-group mt-3">
                                    <label for="Description">Deskripsi</label>
                                    <textarea id="Description" name="Description" class="form-control" rows="4"></textarea>
                                </div>

                                <!-- Product Image -->
                                <div class="form-group mt-3">
                                    <label for="image">Gambar Produk</label>
                                    <input type="file" id="image" name="image" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Tambah Produk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Gambar Produk</th>
                            <th>Nama Produk</th>
                            <th>Harga Jual</th>
                            <th>Stock</th>
                            <th>Satuan</th>
                            <th class="deskripsi">Deskripsi</th>
                            <th>History Harga</th>
                            <th class="edit">Edit</th>
                            <th class="hapus">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr class="{{ $product->CurrentStock < 100 ? 'bg-warning' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset('images/produk/' . $product->image) }}"
                                            alt="Gambar Produk" width="200">
                                    @else
                                        <span>Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td>{{ $product->ProductName }}</td>
                                <td>
                                    {{ $product->pricing ? number_format($product->pricing->UnitPrice, 0, ',', '.') : 'N/A' }}
                                </td>
                                <td>{{ $product->CurrentStock }}</td>
                                <td>{{ $product->ProductUnit }}</td>
                                <td class="deskripsi">{{ $product->Description }}</td>

                                <td>
                                    <button class="detail-button btn btn-info btn-sm"
                                        data-id="{{ $product->ProductID }}">Riwayat Harga</button>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editProductModal{{ $product->ProductID }}">
                                        <i class="bi bi-pencil btn-edit"></i>
                                    </button>
                                </td>
                                <td class="hapus">
                                    <button type="button" class="btn btn-danger delete-btn"
                                        data-id="{{ $product->ProductID }}">
                                        <i class="bi bi-trash btn-danger"></i>
                                    </button>
                                    <form id="delete-form-{{ $product->ProductID }}"
                                        action="{{ route('owner.product.destroy', $product->ProductID) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            <!-- Modal untuk edit produk -->
                            <div class="modal fade" id="editProductModal{{ $product->ProductID }}" tabindex="-1"
                                aria-labelledby="editProductLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('owner.update-product', $product->ProductID) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editProductLabel">Edit Produk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="ProductName">Nama Produk</label>
                                                    <input type="text" id="ProductName" name="ProductName"
                                                        class="form-control" value="{{ $product->ProductName }}"
                                                        required>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="UnitPrice">Harga Jual</label>
                                                    <input type="number" id="UnitPrice" name="UnitPrice"
                                                        class="form-control"
                                                        value="{{ $product->pricing->UnitPrice ?? '' }}" required>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="CurrentStock">Stok</label>
                                                    <input type="number" id="CurrentStock" name="CurrentStock"
                                                        class="form-control" value="{{ $product->CurrentStock }}"
                                                        required>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="ProductUnit">Satuan</label>
                                                    <input type="text" id="ProductUnit" name="ProductUnit"
                                                        class="form-control" value="{{ $product->ProductUnit }}"
                                                        required>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="Description">Deskripsi</label>
                                                    <textarea id="Description" name="Description" class="form-control" rows="4">{{ $product->Description }}</textarea>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <label for="image">Gambar Produk</label>
                                                    <input type="file" id="image" name="image"
                                                        onChange="img_pathUrl(this);" placeholder="Gambar Produk"
                                                        class="form-control" value="{{ $product->image }}">
                                                    @if ($product->image)
                                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                                        <img src="{{ asset('images/produk/' . $product->image) }}"
                                                            id="img_url" alt="Gambar Produk" class="mt-2"
                                                            width="150">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan
                                                    Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal untuk history harga -->
        <div class="modal fade" id="order-modal" tabindex="-1" aria-labelledby="order-modal-label"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="order-modal-label">Riwayat Harga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Waktu Diubah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody id="modal-content">
                                <!-- Data dari API akan dimasukkan di sini -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>

    </div>
    <script>
        function img_pathUrl(input) {
            $('#img_url')[0].src = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
        }
        // Menampilkan modal
        const modalButtons = document.querySelectorAll('[data-modal-target]');
        modalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                document.querySelector(modalId).style.display = 'block';
            });
        });

        // Menutup modal menggunakan tombol close
        const closeButtons = document.querySelectorAll('.close-button');
        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('order-modal').style.display = 'none';
                document.querySelector('.overlay').style.display = 'none';
            });
        });


        // Membuka modal riwayat harga
        document.querySelectorAll('.detail-button').forEach(button => {
            button.addEventListener('click', function() {
                const productID = this.dataset.id; // Mengambil ProductID dari data-id

                // Fetch data dari server
                fetch(`/api/productPrice/${productID}`)
                    .then(response => response.json())
                    .then(data => {
                        const modalContent = document.getElementById('modal-content');
                        modalContent.innerHTML = ''; // Hapus isi modal sebelumnya

                        if (data.details && data.details.length > 0) {
                            // Looping data dari API dan masukkan ke dalam tabel
                            data.details.forEach(detail => {
                                modalContent.innerHTML += `
                            <tr>
                                <td>${detail.timeChanged}</td>
                                <td>${detail.price}</td>
                            </tr>
                        `;
                            });
                        } else {
                            modalContent.innerHTML =
                                `<tr><td colspan="2" class="text-center">Tidak ada data harga</td></tr>`;
                        }

                        // Buka modal menggunakan Bootstrap
                        const orderModal = new bootstrap.Modal(document.getElementById(
                            'order-modal'), {});
                        orderModal.show();
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan saat mengambil data riwayat harga:', error);
                    });
            });
        });
        // Menutup modal jika klik di luar modal
        window.addEventListener('click', (event) => {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const kasirId = this.getAttribute('data-id');
                    const form = document.getElementById(`delete-form-${kasirId}`);

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data produk akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
