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
                                <h6 class="card-title text-truncate">stok {{ $prd->stok }}</h6>
                                <p class="card-text text-danger fw-bold">Rp{{ number_format($prd->harga, 0, ',', '.') }}</p>
                                <button class="btn btn-sm btn-success add-to-cart">Tambah</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Keranjang Belanja (Kanan, Sejajar Produk) -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <span>Keranjang (<span id="cart-count">0</span>)</span>
                    <button class="btn btn-sm btn-light" id="save-order">Save Order</button>
                </div>

                <div class="card-body p-2">
                    <ul class="list-group cart-list" style="max-height: 300px; overflow-y: auto;">
                        <li class="list-group-item text-muted text-center">Keranjang masih kosong</li>
                    </ul>
                </div>

                <div class="card-footer">
                    <p class="mb-1">Total: <span class="float-end" id="total-price">Rp 0</span></p>
                    <p class="mb-1">Total diskon: <span class="float-end" id="total-discount">Rp 0</span></p>
                    <div class="d-flex justify-content-between">
                        <label><input type="checkbox" id="apply-tax"> PPN 10%</label>
                        <span id="tax-amount">Rp 0</span>
                    </div>
                    <hr>
                    <h5>Sub Total: <span class="float-end text-primary fw-bold" id="subtotal">Rp 0</span></h5>
                    <div class="d-flex gap-2 mt-2">
                        <button class="btn btn-success w-100">Simpan Order</button>
                    
                        <button type="button" id="btn-bayar" class="btn btn-primary w-100">Bayar Sekarang</button>
                    </div>                    
                </div>
            </div>
        </div>                    
    </div>
</div>
    <!-- Modal Detail Produk -->
    <div class="modal fade" id="detailProdukModal" tabindex="-1" aria-labelledby="detailProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-sm rounded-3">
                
                <!-- Header Modal -->
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-semibold text-dark">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <!-- Body Modal -->
                <div class="modal-body text-center py-4">
                    <div class="d-flex flex-column align-items-center">
                        <!-- Foto Produk -->
                        <img id="detailFotoProduk" src="" alt="Produk" class="img-fluid rounded-2"
                            style="max-width: 100%; height: 250px; object-fit: cover;">
    
                        <!-- Nama Produk -->
                        <h4 id="detailNamaProduk" class="mt-3 fw-semibold text-dark"></h4>
    
                        <!-- Harga Produk -->
                        <h5 id="detailHargaProduk" class="text-dark fw-normal mt-2"></h5>
    
                        <!-- Kategori Produk -->
                        <span id="detailKategoriProduk" class="text-muted mt-2" style="font-size: 14px;"></span>
                    </div>
                </div>
    
                <!-- Footer Modal -->
                <div class="modal-footer border-top">
                    <!-- Tombol Hapus -->
                    <button class="btn btn-outline-danger hapusProduk">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                    <!-- Tombol Tutup -->
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
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
    $(document).ready(function() {
        let cart = [];
    
        // Fungsi untuk update tampilan keranjang
        function updateCart() {
            let cartList = $(".cart-list");
            cartList.empty();
            let totalPrice = 0, totalDiscount = 0;
    
            if (cart.length === 0) {
                cartList.append('<li class="list-group-item text-muted text-center">Keranjang masih kosong</li>');
            } else {
                cart.forEach((item, index) => {
                    let hargaTotal = (item.harga - item.diskon) * item.jumlah;
                    totalPrice += hargaTotal;
                    totalDiscount += item.diskon * item.jumlah;
    
                    cartList.append(`
                        <li class="list-group-item d-flex align-items-center">
                            <img src="${item.foto}" class="rounded" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                            <div class="flex-grow-1">
                                <a href="#" class="fw-bold">${item.nama}</a>
                                <small class="d-block text-muted">Diskon: Rp${item.diskon.toLocaleString()}/item</small>
                                <small>Rp${item.harga.toLocaleString()} x ${item.jumlah} = <strong>Rp${hargaTotal.toLocaleString()}</strong></small>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary btn-minus" data-index="${index}">-</button>
                                <input type="text" class="form-control form-control-sm text-center" value="${item.jumlah}" style="width: 40px;">
                                <button class="btn btn-sm btn-outline-primary btn-plus" data-index="${index}">+</button>
                                <button class="btn btn-sm btn-outline-danger btn-delete" data-index="${index}">🗑</button>
                            </div>
                        </li>
                    `);
                });
            }
    
            // Update total dan subtotal
            let tax = $("#apply-tax").prop("checked") ? totalPrice * 0.1 : 0;
            $("#total-price").text(`Rp ${totalPrice.toLocaleString()}`);
            $("#total-discount").text(`Rp ${totalDiscount.toLocaleString()}`);
            $("#tax-amount").text(`Rp ${tax.toLocaleString()}`);
            $("#subtotal").text(`Rp ${(totalPrice + tax).toLocaleString()}`);
            $("#cart-count").text(cart.length);
        }
    
        // Tambah produk ke keranjang
        $(".add-to-cart").click(function() {
            let parentCard = $(this).closest(".produk-card");
            let id = parentCard.data("id");
            let nama = parentCard.data("nama");
            let harga = parentCard.data("harga");
            let foto = parentCard.data("foto");
            let diskon = 1000; // Bisa diganti dengan diskon dari database
    
            let item = cart.find(p => p.id === id);
            if (item) {
                item.jumlah += 1;
            } else {
                cart.push({ id, nama, harga, foto, diskon, jumlah: 1 });
            }
            updateCart();
        });
    
        // Hapus produk dari keranjang
        $(document).on("click", ".btn-delete", function() {
            let index = $(this).data("index");
            cart.splice(index, 1);
            updateCart();
        });
    
        // Tambah atau kurang jumlah produk
        $(document).on("click", ".btn-plus", function() {
            let index = $(this).data("index");
            cart[index].jumlah += 1;
            updateCart();
        });
    
        $(document).on("click", ".btn-minus", function() {
            let index = $(this).data("index");
            if (cart[index].jumlah > 1) {
                cart[index].jumlah -= 1;
            } else {
                cart.splice(index, 1);
            }
            updateCart();
        });
    
        // Aktifkan PPN 10%
        $("#apply-tax").change(updateCart);
    
        // Simpan order (hanya alert untuk demo)
        $("#save-order").click(function() {
            alert("Order telah disimpan!");
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
    const cartList = document.querySelector(".cart-list");
    const cartCount = document.getElementById("cart-count");
    const totalPrice = document.getElementById("total-price");
    const totalDiscount = document.getElementById("total-discount");
    const applyTaxCheckbox = document.getElementById("apply-tax");
    const taxAmount = document.getElementById("tax-amount");
    const subtotal = document.getElementById("subtotal");

    let cartItems = []; // Menyimpan data keranjang

    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function (event) {
            event.stopPropagation(); // Mencegah klik membuka modal atau event lain

            const card = this.closest(".produk-card");
            const id = card.getAttribute("data-id");
            const nama = card.getAttribute("data-nama");
            const harga = parseInt(card.getAttribute("data-harga"));
            const foto = card.getAttribute("data-foto");

            // Cek apakah produk sudah ada di keranjang
            let existingItem = cartItems.find(item => item.id === id);

            if (existingItem) {
                existingItem.jumlah++; // Tambah jumlah jika sudah ada
            } else {
                cartItems.push({ id, nama, harga, foto, jumlah: 1 }); // Tambah produk baru
            }

            updateCartDisplay(); // Perbarui tampilan keranjang
        });
    });

    function updateCartDisplay() {
        cartList.innerHTML = ""; // Bersihkan tampilan keranjang
        let totalHarga = 0;
        let totalDiskon = 0;
        let taxValue = 0;

        cartItems.forEach(item => {
            totalHarga += item.harga * item.jumlah;
            totalDiskon += item.jumlah * 1000; // Contoh diskon Rp 1000/item

            const listItem = document.createElement("li");
            listItem.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
            listItem.innerHTML = `
                <div>
                    <p class="mb-0 fw-bold">${item.nama}</p>
                    <small>Rp${item.harga.toLocaleString()} x ${item.jumlah} = <strong>Rp${(item.harga * item.jumlah).toLocaleString()}</strong></small>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-secondary decrease-qty" data-id="${item.id}">-</button>
                    <span class="mx-2">${item.jumlah}</span>
                    <button class="btn btn-sm btn-outline-primary increase-qty" data-id="${item.id}">+</button>
                    <button class="btn btn-sm btn-danger remove-item" data-id="${item.id}">&times;</button>
                </div>
            `;
            cartList.appendChild(listItem);
        });

        // Perhitungan pajak jika dicentang
        if (applyTaxCheckbox.checked) {
            taxValue = totalHarga * 0.1;
        }

        // Update tampilan
        cartCount.textContent = cartItems.length;
        totalPrice.textContent = `Rp ${totalHarga.toLocaleString()}`;
        totalDiscount.textContent = `Rp ${totalDiskon.toLocaleString()}`;
        taxAmount.textContent = `Rp ${taxValue.toLocaleString()}`;
        subtotal.textContent = `Rp ${(totalHarga - totalDiskon + taxValue).toLocaleString()}`;

        // Event untuk hapus item dari keranjang
        document.querySelectorAll(".remove-item").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                cartItems = cartItems.filter(item => item.id !== id);
                updateCartDisplay();
            });
        });

        // Event untuk menambah jumlah item
        document.querySelectorAll(".increase-qty").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                let item = cartItems.find(item => item.id === id);
                if (item) {
                    item.jumlah++;
                    updateCartDisplay();
                }
            });
        });

        // Event untuk mengurangi jumlah item
        document.querySelectorAll(".decrease-qty").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                let item = cartItems.find(item => item.id === id);
                if (item && item.jumlah > 1) {
                    item.jumlah--;
                } else {
                    cartItems = cartItems.filter(item => item.id !== id); // Hapus jika jumlah 0
                }
                updateCartDisplay();
            });
        });
    }

    // Event listener untuk checkbox pajak
    applyTaxCheckbox.addEventListener("change", updateCartDisplay);
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
        document.getElementById("checkout-form").addEventListener("submit", function(event) {
            event.preventDefault(); // Mencegah form submit secara default
        
            let formData = new FormData(this);
        
            fetch(this.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.redirect) {
                    window.location.href = data.redirect; // Redirect ke halaman penjualan setelah transaksi sukses
                } else {
                    alert("Gagal: " + (data.message || "Transaksi gagal!"));
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan, coba lagi!");
            });
        });
        </script>
        <!-- Tambahkan FontAwesome untuk ikon filter jika belum ada -->
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

<script>
document.getElementById("btnFilter").addEventListener("click", function () {
    let searchText = document.getElementById("searchProduk").value.toLowerCase();
    console.log("Filter produk berdasarkan:", searchText);
});
</script>
<script>
    document.getElementById('btn-bayar').addEventListener('click', function () {
        let keranjang = [];
    
        document.querySelectorAll('.cart-list li').forEach(item => {
            keranjang.push({
                namaProduk: item.dataset.nama,  // Pastikan dataset.nama ada
                harga: parseFloat(item.dataset.harga),  // Pastikan dataset.harga ada
                jumlah: parseInt(item.dataset.jumlah)  // Pastikan dataset.jumlah ada
            });
        });
    
        let url = "{{ route('penjualan.index') }}";
        let params = new URLSearchParams();
        params.append('keranjang', JSON.stringify(keranjang));
    
        window.location.href = `${url}?${params.toString()}`;
    });
    </script>
    
@endpush
