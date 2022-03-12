@extends('main')
@section('judul_halaman','Detail')
@section('konten')
<br>
<div class="container">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main">Home</a></li>
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main/keuangan">Rekap</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
    </nav>
    @foreach ($data as $d)
        @if ($d->status == 'debit')
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="row">
                            <strong>Data Tanggal</strong>
                            <div class="col-3"><label>Tanggal</label></div>
                            <div class="col-1"><label>:</label></div>
                            <div class="col-8">
                                <label>{{date('d F Y', strtotime($d->tanggal))}}</label><br>
                                <small>(Dibuat : {{date('d-m-Y H:i:s', strtotime($d->created_at))}})</small><br>
                                <small>(Diubah : {{date('d-m-Y H:i:s', strtotime($d->updated_at))}})</small>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <strong>Data Debit</strong>
                            <div class="col-3"><label>Kode Akun</label></div>
                            <div class="col-1"><label>:</label></div>
                            <div class="col-8"><label>{{$d->akun->kd_akun}}</label></div>
                        </div>
                        <div class="row">
                            <div class="col-3"><label>Nama Akun</label></div>
                            <div class="col-1"><label>:</label></div>
                            <div class="col-8"><label>{{ucwords($d->akun->nama_akun)}}</label></div>
                        </div>
                        <div class="row">
                            <div class="col-3"><label>Keterangan</label></div>
                            <div class="col-1"><label>:</label></div>
                            <div class="col-8">
                                @if(!empty($dt->ket1))
                                    <label>{{ucfirst($d->ket1)}}</label>
                                @else
                                    <label></label>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-2">
                            <strong>Data Kredit</strong>
                            <div class="col-3"><label>Kode Akun</label></div>
                            <div class="col-1"><label>:</label></div>
                            @foreach($data2 as $dt)
                                @if ($dt->kode == $d->kode)
                                    @if ($dt->status == 'kredit')
                                        <div class="col-8"><label>{{$dt->akun->kd_akun}}</label></div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-3"><label>Nama Akun</label></div>
                            <div class="col-1"><label>:</label></div>
                            @foreach($data2 as $dt)
                                @if ($dt->kode == $d->kode)
                                    @if ($dt->status == 'kredit')
                                        <div class="col-8"><label>{{ucwords($dt->akun->nama_akun)}}</label></div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-3"><label>Keterangan</label></div>
                            <div class="col-1"><label>:</label></div>
                             @foreach($data2 as $dt)
                                @if ($dt->kode == $d->kode)
                                    @if ($dt->status == 'kredit')
                                        <div class="col-8">
                                            @if(!empty($dt->ket2))
                                                <label>{{ucfirst($dt->ket2)}}</label>
                                            @else
                                                <label></label>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <div class="row mt-2">
                            <strong>Data Buku Kas</strong>
                            <div class="col-3"><label>Buku Kas</label></div>
                            <div class="col-1"><label>:</label></div>
                            <div class="col-8"><label>{{ucwords($d->kas->bk_kas)}}</label></div>
                        </div>
                        <div class="row">
                            <div class="col-3"><label>Cash/Cashless</label></div>
                            <div class="col-1"><label>:</label></div>
                            <div class="col-8"><label>{{ucwords($d->kas->tipe)}}</label></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <strong>Data Kategori</strong>
                            <div class="col-3"><label>Kategori</label></div>
                            <div class="col-1"><label>:</label></div>
                            <div class="col-8"><label>{{ucwords($d->kategori->name)}}</label></div>
                        </div>
                        <div class="row mt-2">
                            <strong>Nominal Uang</strong>
                            <div class="col-3"><label>Jumlah Uang</label></div>
                            <div class="col-1"><label>:</label></div>
                            <div class="col-8"><label>Rp. {{number_format((float)$d->debit)}}</label></div>
                        </div>
                        <div class="row mt-2">
                            <strong>Data Gambar</strong>
                            <div class="col-3"><label>Gambar</label></div>
                            <div class="col-1"><label>:</label></div>
                            <div class="card" style="width: 15rem;" style="border: none">
                                <img src="{{ url('/assets/'.$d->image) }}" class="card-img-top p-3" alt="...">
                                @if($d->image != 'default/default.png')
                                <div class="card-body">
                                    <a href="{{ url('/assets/'.$d->image) }}" target="_blank">Lihat gambar</a>
                                </div>
                                @else
                                <div class="card-body">
                                    <small>Tidak ada gambar.</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif	
    @endforeach
</div>
@endsection	