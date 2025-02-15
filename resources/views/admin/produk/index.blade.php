@extends('admin.layouts.base')

@section('title', 'Produk')

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
                <i class="fas fa-box"></i> Daftar Produk
            </h3>
        </div>

        <button class="btn btn-custom mb-3" data-toggle="modal" data-target="#tambahProdukModal">
            <i class="fas fa-plus"></i> Tambah Produk
        </button> 

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="produkTable">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $prd)
                        <tr class="text-center" id="row-{{ $prd->id }}">
                            <td>{{ $prd->id }}</td>
                            <td>{{ $prd->nama_produk }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm editProduk" 
                                        data-id="{{ $prd->id }}" 
                                        data-nama="{{ $prd->nama_produk }}" 
                                        data-toggle="modal" 
                                        data-target="#editProdukModal">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm hapusProduk" data-id="{{ $prd->id }}">
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

<!-- Modal Tambah Produk -->
<div class="modal fade" id="tambahProdukModal" tabindex="-1" aria-labelledby="tambahProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahProdukLabel">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.produk.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
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

<!-- Modal Edit Produk -->
<div class="modal fade" id="editProdukModal" tabindex="-1" aria-labelledby="editProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProdukLabel">Edit Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editProdukForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" id="editNamaProduk" class="form-control" required>
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

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    console.log("✅ JavaScript Loaded!");

    $('.editProduk').click(function() {
        let produkId = $(this).data('id');
        let namaProduk = $(this).data('nama');

        $('#editNamaProduk').val(namaProduk);
        $('#editProdukForm').attr('action', '/admin/produk/' + produkId);
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

                            $("#row-" + produkId).fadeOut(500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    }
                });
            }
        });
    });
});
</script>
@endsection
