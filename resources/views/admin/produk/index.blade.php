@extends('admin.layouts.base')

@section('title', 'Produk')

@section('content')
    @include('style')

    <style>
        .produk-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: flex-start;
            margin-top: 20px;
        }

        .produk-card {
            width: 140px;
            /* Lebih kecil dari sebelumnya */
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 10px;
            /* Padding dikurangi */
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .produk-card:hover {
            transform: scale(1.05);
        }

        .produk-card img {
            width: 100%;
            height: 100px;
            /* Ukuran gambar lebih kecil */
            object-fit: cover;
            border-radius: 5px;
        }

        .produk-card h5 {
            margin: 8px 0;
            font-size: 14px;
            /* Ukuran font dikurangi */
            font-weight: bold;
        }

        .produk-card p {
            font-size: 12px;
            /* Lebih kecil */
            color: #666;
        }
       /* Keranjang belanja */
.card {
    width: 100%;
    max-width: 320px; /* Pastikan tidak terlalu lebar */
}

/* Header keranjang */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
}

/* List dalam keranjang */
.cart-list {
    max-height: 250px; /* Batas tinggi agar tidak terlalu panjang */
    overflow-y: auto;
    padding: 0;
}

/* Produk dalam keranjang */
.cart-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px;
    font-size: 14px;
}

/* Gambar produk */
.cart-list img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 5px;
}

/* Tombol tambah/kurang/hapus */
.cart-list button {
    width: 28px;
    height: 28px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

/* Tombol Save Order */
#save-order {
    font-size: 12px;
    padding: 5px 8px;
}

/* Input jumlah */
.cart-list input {
    width: 35px;
    text-align: center;
    font-size: 12px;
    padding: 2px;
}

/* Bagian total harga */
.card-footer {
    font-size: 14px;
    padding: 10px;
}

/* Tombol di bagian bawah */
.card-footer .btn {
    font-size: 13px;
    padding: 8px;
    flex: 1; /* Agar tombol tetap proporsional */
    white-space: nowrap; /* Supaya teks tidak turun */
}

/* Menyesuaikan tombol dalam satu baris */
.d-flex.gap-2 {
    display: flex;
    gap: 5px;
    flex-wrap: nowrap;
}

/* Ukuran subtotal */
#subtotal {
    font-size: 16px;
    font-weight: bold;
}
.btn-custom {
            height: 38px; /* Samakan tinggi semua tombol */
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 15px;
        }
        .form-control-custom {
            height: 38px; /* Samakan tinggi dengan tombol */
            font-size: 14px;
        }
        .input-group {
            max-width: 250px;
        }
    </style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h3><i class="fas fa-box"></i> Daftar Produk</h3>
        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahProdukModal">
            <i class="fas fa-plus"></i> Tambah Produk
        </button>
    </div>

    <!-- Filter Kategori dan Input Pencarian (Sejajar) -->
    <div class="row mb-2">
        <div class="col-lg-9">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <!-- Filter Kategori -->
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-primary kategori-filter active" data-filter="all">Semua</button>
                    @foreach ($kategori as $kat)
                        <button class="btn btn-sm btn-outline-primary kategori-filter" data-filter="{{ strtolower($kat->nama_kategori) }}">
                            {{ $kat->nama_kategori }}
                        </button>
                    @endforeach
                </div>

                <!-- Input Filter Nama Produk -->
                <div class="input-group">
                    <button class="btn btn-light border btn-custom" id="btnFilter">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <input type="text" id="searchProduk" class="form-control form-control-custom" placeholder="Cari produk...">
                </div>
            </div>
        </div>
    </div>

    <!-- Kontainer Produk & Keranjang -->
    <div class="row">
        <!-- Daftar Produk (Kiri) -->
        <div class="col-lg-9">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
                @foreach ($produk as $prd)
                    <div class="col produk-card"
                        data-id="{{ $prd->id }}"
                        data-nama="{{ strtolower($prd->nama_produk) }}"
                        data-harga="{{ $prd->harga }}"
                        data-foto="{{ asset('assets/produk_fotos/' . $prd->foto) }}"
                        data-kategori="{{ strtolower($prd->kategori ? $prd->kategori->nama_kategori : 'tanpa kategori') }}">
            
                        <div class="card border-0 shadow-sm h-100">
                            <img src="{{ asset('assets/produk_fotos/' . $prd->foto) }}" class="card-img-top img-fluid rounded-top" style="height: 120px; object-fit: cover;">
                            <div class="card-body text-center p-2">
                                <h6 class="card-title text-truncate">{{ $prd->nama_produk }}</h6>
                                <h6 class="card-title text-truncate">Stok: {{ $prd->stok }}</h6>
                                <!-- Menampilkan kategori langsung di sini -->
                                <h5 class="text-muted mt-2" style="font-size: 14px;">
                                    {{ $prd->kategori ? $prd->kategori->nama_kategori : 'Tanpa Kategori' }}
                                </h5>
                                <p class="card-text text-danger fw-bold">Rp{{ number_format($prd->harga, 0, ',', '.') }}</p>
                                <button class="btn btn-outline-danger hapusProduk">
                                    <i class="fas fa-trash"></i> 
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>            
        </div>
        <!-- Keranjang Belanja (Kanan) -->
<div class="col-lg-3">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-shopping-cart"></i> Keranjang</h6>
            <button class="btn btn-sm btn-danger" id="clear-cart"><i class="fas fa-trash"></i></button>
        </div>
        <ul class="list-group list-group-flush cart-list"></ul>
        <div class="card-footer d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Total:</span>
                <span id="subtotal" class="fw-bold text-danger">Rp 0</span>
            </div>
            <button class="btn btn-success w-100" id="checkout">Simpan Keranjang</button>
        </div>
    </div>
</div>

    </div>
</div>
    <div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-labelledby="tambahProdukLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahProdukLabel">Tambah Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Menu</label>
                            <input type="text" name="nama_produk" placeholder="Masukkan Nama Produk"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stok" placeholder="Masukkan Stok"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select name="kategori_id" id="kategori" class="form-control">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Menu</label>
                            <input type="number" name="harga" placeholder="Masukkan Harga" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Foto Menu</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Klik Produk untuk Detail
            $('.produk-card').click(function() {
                let produkId = $(this).data('id');
                let namaProduk = $(this).data('nama');
                let harga = $(this).data('harga');
                let foto = $(this).data('foto');
                let kategori = $(this).data('kategori');

                $('#detailNamaProduk').text(namaProduk);
                $('#detailHargaProduk').text('Rp' + harga.toLocaleString('id-ID'));
                $('#detailFotoProduk').attr('src', foto);
                $('#detailKategoriProduk').text('Kategori: ' + kategori);

                $('.editProduk').data('id', produkId);
                $('.hapusProduk').data('id', produkId);

                $('#detailProdukModal').modal('show');
            });

            // Tampilkan Modal Edit Produk dengan Data yang Dipilih
            $('.editProduk').click(function() {
                let produkId = $(this).data('id');
                let card = $('.produk-card[data-id="' + produkId + '"]');

                let namaProduk = card.data('nama');
                let harga = card.data('harga');
                let foto = card.data('foto');
                let kategoriId = card.data('kategori-id');

                $('#editProdukId').val(produkId);
                $('#editNamaProduk').val(namaProduk);
                $('#editHarga').val(harga);
                $('#editKategori').val(kategoriId);
                $('#currentImage').attr('src', foto);

                $('#editProdukModal').modal('show');
            });

            // Hapus Produk dengan SweetAlert
            $('.hapusProduk').click(function(event) {
                event.preventDefault();
                let produkId = $(this).data('id');
                let token = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Produk akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/produk/' + produkId,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire('Sukses!', response.message, 'success')
                                        .then(() => {
                                            location.reload();
                                        });
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                }
                            }
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.produk-card').click(function() {
                let produkId = $(this).data('id');
                let namaProduk = $(this).data('nama');
                let harga = $(this).data('harga');
                let foto = $(this).data('foto');
                let kategori = $(this).data('kategori');

                $('#detailNamaProduk').text(namaProduk);
                $('#detailHargaProduk').text('Rp' + harga.toLocaleString('id-ID'));
                $('#detailFotoProduk').attr('src', foto);
                $('#detailKategoriProduk').text('Kategori: ' + kategori);

                $('#detailProdukModal').modal('show');
            });

            $('.hapusProduk').click(function(event) {
                event.preventDefault();
                let produkId = $(this).data('id');
                let token = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Produk akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/produk/' + produkId,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire('Sukses!', response.message, 'success')
                                        .then(() => {
                                            location.reload();
                                        });
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                }
                            }
                        });
                    }
                });
            });

            // SweetAlert untuk notifikasi tambah & edit produk
            @if (session('success'))
                Swal.fire({
                    title: "Sukses!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            @endif
        });
        $(document).ready(function() {
            $('.produk-card').click(function() {
                let produkId = $(this).data('id');
                let namaProduk = $(this).data('nama');
                let harga = $(this).data('harga');
                let foto = $(this).data('foto');

                $('#detailNamaProduk').text(namaProduk);
                $('#detailHargaProduk').text('Rp' + harga.toLocaleString('id-ID'));
                $('#detailFotoProduk').attr('src', foto);

                $('.editProduk').attr('data-id', produkId);
                $('.hapusProduk').attr('data-id', produkId);

                $('#detailProdukModal').modal('show');
            });

            $('.hapusProduk').click(function(event) {
                event.preventDefault();
                let produkId = $(this).data('id');
                let token = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Produk akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/produk/' + produkId,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire('Sukses!', response.message, 'success');
                                    location.reload();
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                }
                            }
                        });
                    }
                });
            });
            $(document).ready(function() {
                $('.produk-card').click(function() {
                    let produkId = $(this).data('id');
                    let namaProduk = $(this).data('nama');
                    let harga = $(this).data('harga');
                    let foto = $(this).data('foto');
                    let kategori = $(this).data('kategori');

                    $('#detailNamaProduk').text(namaProduk);
                    $('#detailHargaProduk').text('Rp' + harga.toLocaleString('id-ID'));
                    $('#detailFotoProduk').attr('src', foto);
                    $('#detailKategoriProduk').text('Kategori: ' + kategori);

                    $('#detailProdukModal').modal('show');
                });
            });
        });


        document.getElementById('kategoriFilter').addEventListener('change', function() {
            let selectedCategory = this.value.toLowerCase();
            document.querySelectorAll('.produk-card').forEach(function(card) {
                let cardCategory = card.getAttribute('data-kategori').toLowerCase();
                if (selectedCategory === "" || cardCategory === selectedCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
    <script>
            document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".kategori-filter");
    const produkCards = document.querySelectorAll(".produk-card");

    filterButtons.forEach(button => {
        button.addEventListener("click", function () {
            const filter = this.getAttribute("data-filter");

            // Hapus class 'active' dari semua tombol dan tambahkan ke tombol yang diklik
            filterButtons.forEach(btn => btn.classList.remove("active", "btn-primary"));
            this.classList.add("active", "btn-primary");
            this.classList.remove("btn-outline-primary");

            // Loop semua produk dan filter berdasarkan kategori
            produkCards.forEach(card => {
                const kategori = card.getAttribute("data-kategori");

                if (filter === "all" || kategori === filter) {
                    card.style.display = "block"; // Tampilkan produk yang sesuai
                } else {
                    card.style.display = "none"; // Sembunyikan produk yang tidak sesuai
                }
            });
        });
    });
});
 </script>
<script>
    document.getElementById("searchProduk").addEventListener("keyup", function() {
        let searchValue = this.value.toLowerCase();
        let produkCards = document.querySelectorAll(".produk-card");
    
        produkCards.forEach(function(card) {
            let namaProduk = card.getAttribute("data-nama");
    
            if (namaProduk.includes(searchValue)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
    </script>

<script>
    $(document).ready(function () {
        let cart = [];

        function updateCart() {
            let cartList = $('.cart-list');
            cartList.empty();
            let total = 0;

            cart.forEach((item, index) => {
                let subtotal = item.harga * item.qty;
                total += subtotal;

                cartList.append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <img src="${item.foto}" width="40" height="40">
                        <span class="flex-grow-1 ms-2">${item.nama} x${item.qty}</span>
                        <span class="fw-bold text-danger">Rp${subtotal.toLocaleString()}</span>
                        <button class="btn btn-sm btn-outline-danger remove-item" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </li>
                `);
            });

            $('#subtotal').text(`Rp${total.toLocaleString()}`);
        }

        // Tambah ke Keranjang
        $('.produk-card').click(function () {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let harga = $(this).data('harga');
            let foto = $(this).data('foto');

            let existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                existingItem.qty += 1;
            } else {
                cart.push({ id, nama, harga, foto, qty: 1 });
            }

            updateCart();
        });

        // Hapus Item dari Keranjang
        $(document).on('click', '.remove-item', function () {
            let index = $(this).data('index');
            cart.splice(index, 1);
            updateCart();
        });

        // Hapus Semua Item
        $('#clear-cart').click(function () {
            cart = [];
            updateCart();
        });

        // Checkout (simulasi)
        $('#checkout').click(function () {
            if (cart.length === 0) {
                alert('Keranjang kosong!');
                return;
            }

            alert('Checkout berhasil! Pesanan diproses.');
            cart = [];
            updateCart();
        });
    });

    $(document).ready(function() {
    $("#checkout").click(function() {
        let cartItems = [];

        $(".cart-list .cart-item").each(function() {
            let produk_id = $(this).data("id");
            let pelanggan_id = $(this).data("pelanggan-id") || null; // Bisa null jika tidak ada pelanggan
            let qyt = parseInt($(this).find(".cart-quantity").text()); // Ambil jumlah produk

            cartItems.push({
                produk_id: produk_id,
                pelanggan_id: pelanggan_id,
                qyt: qyt
            });
        });

        if (cartItems.length === 0) {
            alert("Keranjang masih kosong!");
            return;
        }

        $.ajax({
            url: "/cart/store", // Sesuaikan dengan route yang benar
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                produk_id: cartItems[0].produk_id,  // Kirim hanya satu produk untuk contoh
                pelanggan_id: cartItems[0].pelanggan_id,
                qyt: cartItems[0].qyt
            },
            success: function(response) {
                alert(response.message);
                window.location.href = "{{ route('penjualan.index') }}"; // Redirect setelah berhasil
            },
            error: function(xhr) {
                alert("Terjadi kesalahan, coba lagi!");
            }
        });
    });
});
</script>

@endpush
