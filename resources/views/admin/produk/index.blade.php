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
            width: 180px;
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
    </style>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-box"></i> Daftar Produk</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahProdukModal">
                <i class="fas fa-plus"></i> Tambah Produk
            </button>
        </div>


        <div class="produk-container">
            <div class="produk-container">
                <div class="input-group mb-3">
                    <select id="kategoriFilter" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->nama_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                @foreach ($produk as $prd)
                    <div class="produk-card" data-id="{{ $prd->id }}" data-nama="{{ $prd->nama_produk }}"
                        data-harga="{{ $prd->harga }}" data-foto="{{ asset('assets/produk_fotos/' . $prd->foto) }}"
                        data-kategori="{{ $prd->kategori ? $prd->kategori->nama_kategori : 'Tanpa Kategori' }}">
                        <img src="{{ asset('assets/produk_fotos/' . $prd->foto) }}" alt="{{ $prd->nama_produk }}">
                        <h5>{{ $prd->nama_produk }}</h5>
                        <p>Rp{{ number_format($prd->harga, 0, ',', '.') }}</p>
                        <p style="font-size: 12px; color: #666;">Kategori:
                            {{ $prd->kategori ? $prd->kategori->nama_kategori : 'Tanpa Kategori' }}</p>
                    </div>
                @endforeach


            </div>


            <!-- Modal Edit Produk -->
            <div class="modal fade" id="editProdukModal" tabindex="-1" aria-labelledby="editProdukLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProdukLabel">Edit Produk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editProdukForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" id="editProdukId" name="id">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" name="nama_produk" id="editNamaProduk" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select name="kategori_id" id="editKategori" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" name="harga" id="editHarga" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Foto Produk</label>
                                    <input type="file" name="foto" class="form-control" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <label>Foto Produk Saat Ini</label><br>
                                    <img id="currentImage" src="" alt="Current Image" style="max-width: 200px;">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="detailProdukModal" tabindex="-1" aria-labelledby="detailProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="detailFotoProduk" src="" alt="Produk"
                        style="max-width: 100%; height: 250px; object-fit: cover; border-radius: 10px;">
                    <h4 id="detailNamaProduk" class="mt-3"></h4>
                    <h5 id="detailHargaProduk" class="text-primary"></h5>
                    <p id="detailKategoriProduk" class="text-secondary mt-2"></p> <!-- Tambahkan kategori -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning editProduk" data-toggle="modal" data-target="#editProdukModal">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger hapusProduk">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
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
@endpush
