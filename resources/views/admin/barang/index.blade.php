@extends('admin.layouts.base')

@section('title', 'Barang')

@section('content')
@include('style')

<style>
.btn-custom {
    background-color: #007bff; 
    color: white;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 14px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    width: 18%;
    margin-top: 20px;
    margin-left: 20px;
}
.btn-custom:hover,
.btn-custom:focus,
.btn-custom:active {
    background-color: #007bff !important;
    color: white !important;
    box-shadow: none !important;
    outline: none !important;
    border: none !important;
    opacity: 1 !important;
}
</style>

<div class="container">
    <div class="card table-container">
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        @endif

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-box"></i> Daftar Barang
            </h3>
        </div>

        <button class="btn btn-custom mb-3" data-toggle="modal" data-target="#tambahBarangModal">
            <i class="fas fa-plus"></i> Tambah Barang
        </button> 

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="barangTable">
                    <thead>
                        <tr class="text-center">
                            {{-- <th>ID</th> --}}
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Produk</th>
                            {{-- <th>Kategori</th> --}}
                            <th>Satuan</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $brg)
                        <tr class="text-center" id="row-{{ $brg->id }}">
                            {{-- <td>{{ $brg->id }}</td> --}}
                            <td>{{ $brg->kode_barang }}</td>
                            <td>{{ $brg->nama_barang }}</td>
                            <td>{{ $brg->produk->nama_produk ?? 'Tidak Ada' }}</td>
                            {{-- <td>{{ $brg->kategori->nama_kategori ?? 'Tidak Ada' }}</td> --}}
                            <td>{{ $brg->satuan }}</td>
                            <td>Rp {{ number_format($brg->harga_jual, 0, ',', '.') }}</td>
                            <td>{{ $brg->stok }}</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm hapusBarang" data-id="{{ $brg->id }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        @endforeach                                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
</div> 

<!-- Modal Tambah Barang -->
<div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Tambah modal-lg untuk memperlebar modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;"> 
                    <div class="row">
                        <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" name="kode_barang" class="form-control" value="{{ $kodeBarang ?? '' }}" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label>Pilih Produk</label>
                            <select name="produk_id" class="form-control" required>
                                <option value="">Pilih Produk</option>
                                @foreach ($produk as $prd)
                                    <option value="{{ $prd->id }}">{{ $prd->nama_produk }}</option>
                                @endforeach
                            </select>                            
                        </div>                        
                        
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Satuan</label>
                            <select name="satuan" class="form-control">
                                <option value="Liter">Liter</option>
                                <option value="Gram">Gram</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Botol">Botol</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    console.log("✅ JavaScript Loaded!");

    $('.hapusBarang').click(function(event) {
        event.preventDefault();

        let barangId = $(this).data('id');
        let token = $('meta[name="csrf-token"]').attr('content'); 

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Barang akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/barang/' + barangId,
                    type: 'DELETE',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });

                            $("#row-" + barangId).fadeOut(500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus barang.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection
