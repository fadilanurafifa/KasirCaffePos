{{-- @extends('admin.layouts.base')
@section('title', 'Transaksi Penjualan')

@section('content')
<div class="container">
    <h2 class="title">Transaksi Penjualan</h2>
    <form id="checkout-form">
        @csrf
        <label>Metode Pembayaran:</label>
        <input type="radio" name="metode_pembayaran" value="CASH" checked> CASH
        <input type="radio" name="metode_pembayaran" value="ONLINE"> ONLINE PAYMENT
    
        <label>Pelanggan:</label>
        <select name="pelanggan_id" id="pelanggan_id">
            <option value="1">Fahmi</option>
            <option value="2">Pelanggan Lain</option>
        </select>
    
        <div id="keranjang">
            <div class="keranjang-item" data-produk-id="1">
                <input type="number" class="jumlah" value="2">
                <span class="subtotal">20000</span>
            </div>
        </div>
    
        <button type="button" id="btn-bayar" class="btn btn-primary w-100">Bayar Sekarang</button>
    </form>
    
@endsection

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

 --}}
 @extends('admin.layouts.base')

 @section('title', 'Transaksi Penjualan')
 
 @section('content')
 <div class="container">
     <h2 class="title text-center mb-4">Transaksi Penjualan</h2>
     
     <div class="mb-3">
         <label class="form-label">Metode Pembayaran:</label><br>
         <input type="radio" name="metode_pembayaran" value="CASH" checked> CASH
         <input type="radio" name="metode_pembayaran" value="ONLINE"> ONLINE PAYMENT
     </div>
 
     <div class="mb-3">
         <label class="form-label">Pelanggan:</label>
         <select id="pelanggan_id" class="form-select">
             <option value="1">Fahmi</option>
             <option value="2">Pelanggan Lain</option>
         </select>
     </div>
 
     <div class="table-responsive">
         <table id="keranjang" class="table table-bordered">
             <thead class="table-dark">
                 <tr>
                     <th>Nama Produk</th>
                     <th>Harga</th>
                     <th>Jumlah</th>
                     <th>Subtotal</th>
                     <th>Aksi</th>
                 </tr>
             </thead>
             <tbody>
                 @if(isset($keranjang) && is_array($keranjang) && count($keranjang) > 0)
                     @foreach($keranjang as $item)
                         <tr>
                             <td>{{ $item['namaProduk'] ?? 'Tidak ada nama' }}</td>
                             <td>Rp{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                             <td>{{ $item['jumlah'] ?? 0 }}</td>
                             <td>Rp{{ number_format(($item['harga'] ?? 0) * ($item['jumlah'] ?? 0), 0, ',', '.') }}</td>
                             <td><button class="btn btn-danger">Hapus</button></td>
                         </tr>
                     @endforeach
                 @else
                     <tr><td colspan="5" class="text-center">Keranjang kosong</td></tr>
                 @endif
             </tbody>
         </table>
     </div>
 
     <div class="mb-3">
         <label class="form-label">Uang Bayar:</label>
         <input type="number" id="uang_bayar" class="form-control" placeholder="Masukkan uang pembayaran">
     </div>
     
     <div class="mb-3">
         <label class="form-label">Kembalian:</label>
         <input type="text" id="kembalian" class="form-control" readonly>
     </div>
 
     <button id="btn-bayar" class="btn btn-primary w-100">Bayar Sekarang</button>
 </div>
 @endsection
 
 @push('script')
 <script>
     let keranjang = [];
 
     function tambahProduk(id, nama, harga) {
         let jumlah = 1;
         let subtotal = harga * jumlah;
         let item = { id, nama, harga, jumlah, subtotal };
         keranjang.push(item);
         renderKeranjang();
     }
 
     function renderKeranjang() {
         let tbody = document.getElementById('keranjang').querySelector('tbody');
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
                 </tr>`;
         });
     }
 
     function hapusProduk(index) {
         keranjang.splice(index, 1);
         renderKeranjang();
     }
 
     document.getElementById('uang_bayar').addEventListener('input', function () {
         let totalBayar = keranjang.reduce((sum, item) => sum + item.subtotal, 0);
         let uangBayar = parseFloat(this.value);
         let kembalian = uangBayar - totalBayar;
         document.getElementById('kembalian').value = kembalian >= 0 ? kembalian.toLocaleString('id-ID') : 'Uang tidak cukup!';
     });
 
     document.getElementById('btn-bayar').addEventListener('click', function () {
         let pelangganId = document.getElementById('pelanggan_id').value;
         let metodePembayaran = document.querySelector('input[name="metode_pembayaran"]:checked').value;
         let uangBayar = parseFloat(document.getElementById('uang_bayar').value);
         let totalBayar = keranjang.reduce((sum, item) => sum + item.subtotal, 0);
 
         if (uangBayar < totalBayar) {
             alert("Uang tidak cukup!");
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
                 keranjang: keranjang
             })
         })
         .then(res => res.json())
         .then(data => {
             if (data.redirect) {
                 window.location.href = data.redirect;
             } else {
                 alert("Gagal: " + data.message);
             }
         })
         .catch(err => console.error("Error:", err));
     });
 </script>
 @endpush
 
