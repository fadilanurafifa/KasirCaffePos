@extends('admin.layouts.base')

@section('title', 'Pelanggan')

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
        width: 20%;
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
                <i class="fas fa-users"></i> Daftar Pelanggan
            </h3>
        </div>

        <button class="btn btn-custom mb-3" data-toggle="modal" data-target="#tambahPelangganModal">
            <i class="fas fa-plus"></i> Tambah Pelanggan
        </button>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggan as $p)
                        <tr id="row-{{ $p->id }}">
                            <td>{{ $p->kode_pelanggan }}</td>
                            <td id="nama-{{ $p->id }}">{{ $p->nama }}</td>
                            <td id="alamat-{{ $p->id }}">{{ $p->alamat }}</td>
                            <td id="no_telp-{{ $p->id }}">{{ $p->no_telp }}</td>
                            <td id="email-{{ $p->id }}">{{ $p->email }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm editPelanggan" data-id="{{ $p->id }}" data-nama="{{ $p->nama }}" data-alamat="{{ $p->alamat }}" data-no_telp="{{ $p->no_telp }}" data-email="{{ $p->email }}">
                                    <i class="fas fa-edit"></i> 
                                </button>
                                <button class="btn btn-danger btn-sm hapusPelanggan" data-id="{{ $p->id }}">
                                    <i class="fas fa-trash"></i> 
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

<!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="tambahPelangganModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama Pelanggan :</label>
                        <input type="text" name="nama" placeholder="Masukkan Nama Pelanggan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat :</label>
                        <input type="text" name="alamat" placeholder="Masukkan Alamat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No. Telepon :</label>
                        <input type="text" name="no_telp" placeholder="Masukkan No. Telepon" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" name="email" placeholder="Masukkan Email" class="form-control">
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

<!-- Modal Edit Pelanggan -->
<div class="modal fade" id="editPelangganModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="editPelangganForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama">Nama Pelanggan :</label>
                        <input type="text" id="edit_nama" name="nama" placeholder="Masukkan Nama Pelanggan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_alamat">Alamat :</label>
                        <input type="text" id="edit_alamat" name="alamat" placeholder="Masukkan Alamat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_no_telp">No. Telepon :</label>
                        <input type="text" id="edit_no_telp" name="no_telp" placeholder="Masukkan No. Telepon" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email :</label>
                        <input type="email" id="edit_email" name="email" placeholder="Masukkan Email" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
    // Edit Pelanggan
    $(document).on('click', '.editPelanggan', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');
        let alamat = $(this).data('alamat');
        let no_telp = $(this).data('no_telp');
        let email = $(this).data('email');

        $('#edit_id').val(id);
        $('#edit_nama').val(nama);
        $('#edit_alamat').val(alamat);
        $('#edit_no_telp').val(no_telp);
        $('#edit_email').val(email);
        $('#editPelangganModal').modal('show');
    });

    // Update Pelanggan
    $('#editPelangganForm').submit(function(event) {
        event.preventDefault();
        let id = $('#edit_id').val();
        let nama = $('#edit_nama').val();
        let alamat = $('#edit_alamat').val();
        let no_telp = $('#edit_no_telp').val();
        let email = $('#edit_email').val();

        $.ajax({
            url: '/pelanggan/' + id,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                nama: nama,
                alamat: alamat,
                no_telp: no_telp,
                email: email
            },
            success: function(response) {
                $('#nama-' + id).text(nama);
                $('#alamat-' + id).text(alamat);
                $('#no_telp-' + id).text(no_telp);
                $('#email-' + id).text(email);
                $('#editPelangganModal').modal('hide');
                Swal.fire('Sukses!', 'Pelanggan berhasil diperbarui.', 'success');
            },
            error: function(xhr) {
                Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui data.', 'error');
            }
        });
    });

    // Hapus Pelanggan
    $(document).on('click', '.hapusPelanggan', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Pelanggan akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/pelanggan/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        $('#row-' + id).fadeOut();
                        Swal.fire('Terhapus!', 'Pelanggan berhasil dihapus.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus pelanggan.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
