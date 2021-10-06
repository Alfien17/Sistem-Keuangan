@extends('main')
@section('judul_halaman','Detail')
@section('konten')
<br>
<div class="container">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item text-black"><a href="/main">Home</a></li>
        <li class="breadcrumb-item text-black"><a href="/main/keuangan">Rekap</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
    </nav>
    @foreach ($data as $d)
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 mb-2">
                    <div class="row">
                        <div class="col-3">
                            <label>Tanggal</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8 mb-2">
                            <label>{{date('d F Y', strtotime($d->tanggal))}}</label><br>
                            <small>(Dibuat : {{date('d-m-Y H:i:s', strtotime($d->created_at))}})</small><br>
                            <small>(Diubah : {{date('d-m-Y H:i:s', strtotime($d->updated_at))}})</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Kode Akun</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            @foreach ($akun as $a)
                                @if($d->akun_id == $a->id)
                                <label>{{$a->kd_akun}} - {{ucwords($a->nama_akun)}}</label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Buku Kas</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            @foreach ($kas as $a)
                                @if($d->kas_id == $a->id)
                                <label>{{ucwords($a->bk_kas)}}</label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Cash/Cashless</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            @foreach ($kas as $a)
                                @if($d->kas_id == $a->id)
                                <label>{{$a->tipe}}</label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Keterangan</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            <label>{{ucfirst($d->ket)}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Kategori</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            @foreach ($kat as $a)
                                @if($d->kat_id == $a->id)
                                <label>{{ucwords($a->name)}}</label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label>Jumlah Uang</label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            @if ($d->debit==0)
                                <label>Rp. {{number_format((float)$d->kredit)}}</label>
                            @else
                                <label>Rp. {{number_format((float)$d->debit)}}</label>
                            @endif
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row">
                        <div class="col-3">
                            <label>
                                Saldo Akun 
                                @foreach ($akun as $a)
                                    @if($d->akun_id == $a->id)
                                    {{$a->kd_akun}}
                                @endif
                                @endforeach
                                </label>
                        </div>
                        <div class="col-1">
                            <label>:</label>
                        </div>
                        <div class="col-8">
                            <label>Rp. {{number_format((float)$total)}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <strong>Saldo Total</strong>
                        </div>
                        <div class="col-1">
                            <strong>:</strong>
                        </div>
                        <div class="col-8">
                            <strong>Rp. {{number_format((float)$saldo)}}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Gambar :</label><br>
                    <div class="card border-0" style="width: 15rem;" style="border: none">
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
    @endforeach
</div>
@endsection	