@extends('admin.layouts.base')

@section('title', 'Kategori')

@section('content')

@include('style')
@push('style')  
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
@endpush

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
        <i class="fas fa-folder-open"></i> Daftar Kategori
    </h3>
</div>
    <button class="btn btn-custom mb-3" data-toggle="modal" data-target="#tambahKategoriModal">
    <i class="fas fa-plus"></i> Tambah Kategori
</button> 
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $kat)
                        <tr id="row-{{ $kat->id }}">
                            <td>{{ $kat->id }}</td>
                            <td>{{ $kat->nama_kategori }}</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm hapusKategori" data-id="{{ $kat->id }}">
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
<!-- Modal Tambah Kategori -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" name="nama_kategori" placeholder="Masukkan Nama Kategori" class="form-control" required>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log("✅ JavaScript Loaded!");

    $(document).on('click', '.hapusKategori', function(event) {
        event.preventDefault();

        let kategoriId = $(this).data('id');
        let token = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Kategori akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/kategori/' + kategoriId,
                    type: 'DELETE',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Dihapus!',
                            text: 'Kategori berhasil dihapus.',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        $("#row-" + kategoriId).fadeOut(500, function() {
                            $(this).remove();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus kategori.',
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
    
@endpush



