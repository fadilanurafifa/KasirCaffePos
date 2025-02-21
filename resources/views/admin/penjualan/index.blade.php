{{-- @extends('admin.layouts.base')

@section('title', 'Transaksi Penjualan')

@section('content')

@include('style') --}}

<!-- Container untuk halaman utama -->
{{-- <div class="container mt-4"> --}}
    {{-- <div class="row">
        <!-- Kolom kiri: Statistik Penjualan -->
        <div class="col-md-4">
            <div class="card shadow border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Statistik Penjualan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Total Penjualan Bulan Ini:</strong> Rp 5.000.000</li>
                        <li class="list-group-item"><strong>Jumlah Produk Terjual:</strong> 150 Produk</li>
                        <li class="list-group-item"><strong>Jumlah Transaksi:</strong> 45 Transaksi</li>
                    </ul>
                </div>
            </div>
        </div> --}}

        <!-- Kolom kanan: Daftar Produk -->
        {{-- <div class="col-md-8">
            <div class="card shadow border-0 rounded-lg mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Daftar Produk</h5>
                </div>
                <div class="card-body p-3">
                    <table class="table table-hover table-bordered rounded-lg">
                        <thead class="bg-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produk as $p)
                            <tr>
                                <td>{{ $p->nama_produk }}</td>
                                <td>{{ number_format($p->harga) }}</td>
                                <td>{{ $p->kategori->nama_kategori ?? 'Tanpa Kategori' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol untuk membuka modal, tetap berada di atas -->
    <div class="card shadow border-0 rounded-lg mb-4 sticky-top bg-white" id="topButtonContainer">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h3 class="m-0">Transaksi Penjualan</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#transaksiModal">
                Tambah Transaksi
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="transaksiModal" tabindex="-1" role="dialog" aria-labelledby="transaksiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="transaksiModalLabel">Form Transaksi Penjualan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penjualan.store') }}" method="POST">
                        @csrf

                        <!-- Bagian Pelanggan -->
                        <div class="form-group">
                            <label for="pelanggan_id">Pelanggan</label>
                            <select name="pelanggan_id" id="pelanggan_id" class="form-control custom-select">
                                @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tabel Pilihan Produk -->
                        <div class="form-group">
                            <label>Pilih Produk</label>
                            <table class="table table-bordered table-hover rounded-lg">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produk as $p)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="produk_id[]" value="{{ $p->id }}">
                                            {{ $p->nama_produk }}
                                        </td>
                                        <td>{{ number_format($p->harga ?? 0) }}</td>
                                        <td>
                                            <input type="number" name="jumlah[]" value="1" class="form-control jumlah-input" disabled>
                                        </td>                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
{{-- 
@endsection

@push('style')
<style>
    .modal-content {
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .modal-footer {
        background-color: #f8f9fa;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .table thead {
        background-color: #f8f9fa;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }

    .btn {
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 8px;
    }

    #topButtonContainer {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: white;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
    }

    .card-body {
        padding: 1.5rem;
    }
</style>
@endpush


@push('script')
<script>
        $(document).ready(function() {
    $('.produk-checkbox').change(function() {
        let jumlahInput = $(this).closest('tr').find('.jumlah-input');
        jumlahInput.prop('disabled', !$(this).is(':checked'));
    });
});
</script>
@endpush --}}

{{-- @extends('admin.layouts.base')
@section('title', 'Transaksi Penjualan')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-200">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800 text-center">Transaksi Penjualan</h2>

    <!-- Pilih Pelanggan -->
    <div class="mb-6">
        <label class="block text-gray-700 font-medium mb-2">Pelanggan</label>
        <select id="pelanggan" class="w-full p-3 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach ($pelanggan as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tambah Produk -->
    <div class="mb-6">
        <label class="block text-gray-700 font-medium mb-2">Produk</label>
        <select id="produk" class="w-full p-3 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach ($produk as $p)
                <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">{{ $p->nama_produk }} - Rp{{ number_format($p->harga, 0, ',', '.') }}</option>
            @endforeach
        </select>
        <input type="number" id="jumlah" class="w-full p-3 border rounded-lg mt-3 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Jumlah" min="1" value="1">
        <button onclick="tambahProduk()" class="mt-3 w-full bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg font-semibold">Tambah Produk</button>
    </div>

    <!-- Keranjang -->
    <h3 class="text-xl font-semibold mt-6 text-gray-800">Keranjang</h3>
    <div class="overflow-x-auto mt-3">
        <table class="w-full border rounded-lg overflow-hidden shadow-md">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-3 text-left">Produk</th>
                    <th class="p-3 text-center">Harga</th>
                    <th class="p-3 text-center">Jumlah</th>
                    <th class="p-3 text-center">Subtotal</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="keranjang" class="bg-white">
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="text-right mt-6 text-lg font-semibold text-gray-800">
        Total: Rp <span id="totalBayar">0</span>
    </div>

    <!-- Tombol Simpan -->
    <button onclick="simpanTransaksi()" class="w-full bg-green-600 hover:bg-green-700 text-white p-3 rounded-lg mt-6 font-semibold">Simpan Transaksi</button>
</div>

<script>
    let keranjang = [];
    
    function tambahProduk() {
        let produk = document.getElementById('produk');
        let jumlah = document.getElementById('jumlah').value;
        let harga = produk.options[produk.selectedIndex].getAttribute('data-harga');
        let nama = produk.options[produk.selectedIndex].text;

        let item = {
            id: produk.value,
            nama: nama,
            harga: parseFloat(harga),
            jumlah: parseInt(jumlah),
            subtotal: parseFloat(harga) * parseInt(jumlah)
        };

        keranjang.push(item);
        renderKeranjang();
    }

    function renderKeranjang() {
        let tbody = document.getElementById('keranjang');
        tbody.innerHTML = "";
        let total = 0;

        keranjang.forEach((item, index) => {
            total += item.subtotal;
            tbody.innerHTML += `
                <tr class="border-b">
                    <td class="p-3">${item.nama}</td>
                    <td class="p-3 text-center">Rp${item.harga}</td>
                    <td class="p-3 text-center">${item.jumlah}</td>
                    <td class="p-3 text-center">Rp${item.subtotal}</td>
                    <td class="p-3 text-center">
                        <button onclick="hapusProduk(${index})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">Hapus</button>
                    </td>
                </tr>
            `;
        });

        document.getElementById('totalBayar').innerText = total;
    }

    function hapusProduk(index) {
        keranjang.splice(index, 1);
        renderKeranjang();
    }

    function simpanTransaksi() {
        let pelangganId = document.getElementById('pelanggan').value;

        fetch("{{ route('penjualan.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                pelanggan_id: pelangganId,
                produk: keranjang
            })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
@endsection --}}
@extends('admin.layouts.base')
@section('title', 'Transaksi Penjualan')

@section('content')
<div class="container">
    <h2 class="title">Transaksi Penjualan</h2>

    <!-- Pilih Pelanggan -->
    <div class="form-group">
        <label>Pelanggan</label>
        <select id="pelanggan" class="form-control">
            @foreach ($pelanggan as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tambah Produk -->
    <div class="form-group">
        <label>Produk</label>
        <select id="produk" class="form-control">
            @foreach ($produk as $p)
                <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">
                    {{ $p->nama_produk }} - Rp{{ number_format($p->harga, 0, ',', '.') }}
                </option>
            @endforeach
        </select>
        <input type="number" id="jumlah" class="form-control mt-2" placeholder="Jumlah" min="1" value="1">
        <button onclick="tambahProduk()" class="btn btn-primary mt-2">Tambah Produk</button>
    </div>

    <!-- Keranjang -->
    <h3 class="sub-title">Keranjang</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="keranjang"></tbody>
    </table>

    <!-- Total dengan Box -->
    <div class="total-box">
        <strong>Total: Rp <span id="totalBayar">0</span></strong>
    </div>

    <!-- Tombol Simpan -->
    <button onclick="simpanTransaksi()" class="btn btn-success">Simpan Transaksi</button>
</div>
@endsection

@push('styles')
<style>
.container {
    max-width: 800px;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    color: #333;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.table th {
    background: #f5f5f5;
}

.total-box {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    margin: 20px 0;
    padding: 15px;
    background: #f8f9fa;
    border: 3px solid #28a745;
    border-radius: 8px;
    color: #28a745;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.btn {
    display: block;
    width: 100%;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-primary {
    background: #007bff;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-success {
    background: #28a745;
    color: white;
    border: none;
}

.btn-success:hover {
    background: #1e7e34;
}

.btn-danger {
    background: #dc3545;
    color: white;
    border: none;
}

.btn-danger:hover {
    background: #bd2130;
}
</style>
@endpush

@push('script')
<script>
   let keranjang = [];

function tambahProduk() {
    let produk = document.getElementById('produk');
    let jumlah = document.getElementById('jumlah').value;

    if (jumlah <= 0) {
        alert("Jumlah produk harus lebih dari 0.");
        return;
    }

    let harga = produk.options[produk.selectedIndex].getAttribute('data-harga');
    let nama = produk.options[produk.selectedIndex].text;

    let item = {
        id: produk.value,
        nama: nama,
        harga: parseFloat(harga),
        jumlah: parseInt(jumlah),
        subtotal: parseFloat(harga) * parseInt(jumlah)
    };

    keranjang.push(item);
    renderKeranjang();
}

function renderKeranjang() {
    let tbody = document.getElementById('keranjang');
    tbody.innerHTML = "";
    let total = 0;

    keranjang.forEach((item, index) => {
        total += item.subtotal;
        tbody.innerHTML += `
            <tr>
                <td>${item.nama}</td>
                <td>Rp${item.harga.toLocaleString('id-ID')}</td>
                <td>${item.jumlah}</td>
                <td>Rp${item.subtotal.toLocaleString('id-ID')}</td>
                <td>
                    <button onclick="hapusProduk(${index})" class="btn btn-danger">Hapus</button>
                </td>
            </tr>
        `;
    });

    document.getElementById('totalBayar').innerText = total.toLocaleString('id-ID');
}

function hapusProduk(index) {
    keranjang.splice(index, 1);
    renderKeranjang();
}

function simpanTransaksi() {
    let pelangganId = document.getElementById('pelanggan').value;
    let metodePembayaran = document.getElementById('metode_pembayaran').value;

    console.log('tes')

    if (keranjang.length === 0) {
        alert("Keranjang masih kosong!");
        return;
    }

    fetch("{{ route('penjualan.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            pelanggan_id: pelangganId,
            metode_pembayaran: metodePembayaran,
            produk: keranjang
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert("Gagal: " + data.error);
        }
    })
    .catch(err => console.error("Error:", err));
}

// function simpanTransaksi() {
//     console.log('test');
// }
</script>
@endpush


