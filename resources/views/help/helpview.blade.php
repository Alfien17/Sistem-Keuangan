@extends('main')
@section('judul_halaman','Bantuan dan Tips')
@section('konten')
<br>
<div class="card shadow">
    <div class="card-body">
    <div class="accordion" id="accordionExample">
        <div class="accordion-item border-0">
            <h4 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <p>Kembali secara tiba-tiba ke login</p>
                </button>
            </h4>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Itu merupakan fitur <strong>session expired</strong>, dimana halaman akan kembali ke login ketika user tidak melakukan aktivitas
                    selama <strong>2 jam</strong>.
                </div>
            </div>
            <h4 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <p>Error 419 | Page Expired</p>
                </button>
            </h4>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Silahkan untuk kembali ke halaman login dan <strong>refresh page</strong> terlebih dahulu sebelum mencoba login kembali.
                </div>
            </div>
            <h4 class="accordion-header" id="heading9">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                    <p>Email yang digunakan untuk regristasi</p>
                </button>
            </h4>
            <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Pastikan untuk menggunakan email yang aktif pada saat regristasi, karena pada saat melakukan ubah password link akan
                    dikirimkan ke email yang Anda gunakan.
                </div>
            </div>
            <h4 class="accordion-header" id="heading3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                    <p>Lupa Password</p>
                </button>
            </h4>
            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>Pertama</strong>, klik <strong style="cursor: pointer"><a href="/main/editakun/{{Auth::user()->id ??''}}" class="text-dark" style="text-decoration: none"> Lupa Password?</a></strong> lalu masukkan email Anda.<br>
                    <strong>Kedua</strong>, cek email masuk pada email Anda di <strong>kotak masuk</strong> atau <strong>spam</strong>. Jika berada di spam,
                    maka izinkan email dengan cara <strong>bukan spam</strong> agar link pada email dapat di akses.<br>
                    <strong>Ketiga</strong>, masukkan password baru dan Konfirmasi password.
                </div>
            </div>
            @if(Auth::user()->bagian == 'cashier' || Auth::user()->bagian == 'accounting')
            <h4 class="accordion-header" id="heading4">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                    <p>Tambah dan Ubah Data Keuangan</p>
                </button>
            </h4>
            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Pastikan akun, buku kas, dan kategori tersedia pada input.<br>
                    Akun pada debit dan kredit <strong>tidak boleh sama.</strong><br>
                    Debit dan kredit otomatis terbentuk dengan sekali submit.
                </div>
            </div>
            <h4 class="accordion-header" id="heading5">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                    <p>Peringatan sebelum melakukan hapus akun, kategori akun, buku kas, dan kategori</p>
                </button>
            </h4>
            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>Hapus Akun </strong><br>
                    Yang akan terhapus : <strong>akun</strong> yang dipilih dan <strong> data keuangan</strong> yang berhubungan dengan akun.<br>
                    <strong>Hapus Kategori Akun </strong><br>
                    Yang akan terhapus : <strong>kategori akun</strong> yang dipilih.<br>
                    <strong>Hapus Buku Kas </strong><br>
                    Yang akan terhapus : <strong>buku kas</strong> yang dipilih dan <strong>data keuangan</strong> yang berhubungan dengan akun.<br>
                    <strong>Hapus Kategori </strong><br>
                    Yang akan terhapus : <strong>kategori</strong> yang dipilih dan <strong>data keuangan</strong> yang berhubungan dengan akun.<br>
                </div>
            </div>
            <h4 class="accordion-header" id="heading6">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                    <p>Relasi yang terdapat pada database</p>
                </button>
            </h4>
            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Tabel-tabel yang terdapat pada aplikasi ini <strong>berhubungan satu sama lainnya</strong>. Sehingga ketika
                    menghapus satu data pada tabel A (contoh tabel akun), maka pada tabel B (contoh tabel rekap keuangan) akan ikut terhapus pada
                    data yang memiliki relasi dengan tabel A.
                </div>
            </div>
            <h4 class="accordion-header" id="heading7">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                    <p>Value dari Kode, Buku Kas, Cash/Cashless, dan Kategori menghilang di tabel rekap setelah user melakukan hapus data atau reset data</p>
                </button>
            </h4>
            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Silahkan untuk melakukan edit data pada value yang hilang atau jika Anda sedang melakukan pembersihan data keuangan di aplikasi,
                    reset semua data secara keseluruhan mulai dari Akun, Buku Kas, Kategori, dan Keuangan di menu 
                    <strong style="cursor: pointer"><a href="/main/reset-data" class="text-dark" style="text-decoration: none"> Reset Data</a></strong>.
                </div>
            </div>
            <h4 class="accordion-header" id="heading8">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                    <p>Terdapat checkbox di bawah gambar ketika melakukan ubah data keuangan</p>
                </button>
            </h4>
            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Jika Anda menceklis checkbox yang ada di bawah gambar lalu menekan tombol update, maka gambar pada data keuangan tersebut akan terhapus dan menjadi gambar default. 
                </div>
            </div>
            @endif
        </div>
    </div>
    </div>
</div>
@endsection	