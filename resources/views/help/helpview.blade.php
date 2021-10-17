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
            <h4 class="accordion-header" id="heading4">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                    <p>Aturan tambah debit dan kredit</p>
                </button>
            </h4>
            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>Pertama</strong>, pastikan akun tersedia pada input.<br>
                    <strong>Kedua</strong>, tambah debit terlebih dahulu sebelum kredit.<br>
                    <strong>Ketiga</strong>, besarnya jumlah kredit <strong>tidak lebih besar dari</strong> besarnya saldo pada akun. 
                </div>
            </div>
            <h4 class="accordion-header" id="heading5">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                    <p>Aturan edit debit dan kredit</p>
                </button>
            </h4>
            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>Pertama</strong>, pastikan akun tersedia pada input.<br>
                    <strong>Kedua</strong>, sebelum melakukan edit kredit, pastikan jumlah keuangan pada akun yang dituju cukup dan tidak melebihi batas.<br>
                    <strong>Ketiga</strong>, cara menghitung batas kredit adalah sebagai berikut:<br>
                    <div class="row">
                        <div class="col-3">Saldo akun 1-101 (S)</div> <div class="col-2"> = Rp. 500,000</div>
                    </div>
                    <div class="row">
                        <div class="col-3">Besar kredit sebelum diedit (K)</div> <div class="col-2"> = Rp. 20,000</div>
                    </div>
                    <div class="row">
                        <div class="col-3">Batas edit kredit (S+K)</div> <div class="col-2"> = Rp. 520,000</div>
                    </div>
                    Maka, batas edit kredit yang dapat dilakukan pada akun 1-101 adalah Rp. 520,000.
                </div>
            </div>
            <h4 class="accordion-header" id="heading6">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                    <p>Aturan hapus debit dan kredit</p>
                </button>
            </h4>
            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Hapus debit dan kredit akan membatasi user dalam menghapus data (terutama debit) jika <strong> jumlah keuangan debit pada suatu akun 
                    ternyata lebih sedikit daripada jumlah keuangan kreditnya</strong>, karena akan memungkinkan saldo pada akun tersebut dibawah nol.
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
        </div>
    </div>
    </div>
</div>
@endsection	