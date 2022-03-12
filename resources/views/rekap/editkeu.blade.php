@extends('main')
@section('judul_halaman','Ubah Data Keuangan')
@section('konten')
<br>
    @if(Session::has('g_editkeu'))
        <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_editkeu')}}
        </div>
    @endif
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a class="text-dark" href="/main">Home</a></li>
                <li class="breadcrumb-item"><a class="text-dark" href="/main/keuangan">Rekap</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
    @foreach($data as $d)
        @if ($d->status == 'debit')
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="/updatekeu/{{$d->id}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <strong>Data Tanggal</strong>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Tanggal</label>
                            <div class="col-sm-7">
                                <input type="date" name="tanggal" class="form-control effect-1 {{$errors->has('tanggal')?'is-invalid':''}}"  value="{{$d->tanggal}}" required>
                                <input type="hidden" name="id" value="{{$d->id}}">
                                <span class="focus-border"></span>
                                <div class="valid-tooltip">
                                    Great!
                                </div>
                                @error('tanggal')
                                    <div class="invalid-tooltip">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <strong>Data Debit</strong>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Kode Akun</label>
                            <div class="col-sm-7">
                                @if(!empty($d->akun->kd_akun))
                                    <input name="kd_akun1" list="datalistOptions" id="exampleDataList" value="{{$d->akun->kd_akun}}" autocomplete="off" class="form-control effect-1 
                                        {{Session::has('g_kdakun1')||Session::has('g_kdakun3')?'is-invalid':''}}" type="text" placeholder="Ex 1-101...(Untuk Debit)" required>
                                @else
                                    <input name="kd_akun1" list="datalistOptions" id="exampleDataList" value="{{old('kd_akun1')}}" autocomplete="off" class="form-control effect-1 
                                        {{Session::has('g_kdakun1')||Session::has('g_kdakun3')?'is-invalid':''}}" type="text" placeholder="Ex 1-101...(Untuk Debit)" required>
                                @endif
                                <datalist id="datalistOptions">
                                    @foreach ($akun as $a)
                                        <option value="{{$a->kd_akun}}">{{ucwords($a->nama_akun)}}
                                    @endforeach
                                </datalist>
                                <span class="focus-border"></span>
                                <div class="valid-tooltip">
                                    Great!
                                </div>
                                @if(Session::has('g_kdakun1')||Session::has('g_kdakun3'))
                                    <div class="invalid-tooltip">
                                        {{Session::get('g_kdakun1')}}{{Session::get('g_kdakun3')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-7">
                                <input type="text" name="ket1" class="form-control effect-1" value="{{$d->ket1}}" autocomplete="off" placeholder="Ex Qurban... (boleh dikosongkan)">
                                <span class="focus-border"></span>
                            </div>
                        </div>
                    </div>
                    <strong>Data Kredit</strong>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Kode Akun</label>
                            <div class="col-sm-7">
                                @foreach($data2 as $dt)
                                    @if ($dt->kode == $d->kode)
                                        @if ($dt->status == 'kredit')
                                            @if(!empty($dt->akun->kd_akun))
                                                <input name="kd_akun2" list="datalistOptions" id="exampleDataList" value="{{$dt->akun->kd_akun}}" autocomplete="off" class="form-control effect-1 
                                                    {{Session::has('g_kdakun2')||Session::has('g_kdakun3')?'is-invalid':''}}" type="text" placeholder="Ex 1-101...(Untuk Kredit)" required>
                                            @else
                                                <input name="kd_akun2" list="datalistOptions" id="exampleDataList" value="{{old('kd_akun2')}}" autocomplete="off" class="form-control effect-1 
                                                    {{Session::has('g_kdakun2')||Session::has('g_kdakun3')?'is-invalid':''}}" type="text" placeholder="Ex 1-101...(Untuk Kredit)" required>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                <datalist id="datalistOptions">
                                    @foreach ($akun as $a)
                                        <option value="{{$a->kd_akun}}">{{ucwords($a->nama_akun)}}
                                    @endforeach
                                </datalist>
                                <span class="focus-border"></span>
                                <div class="valid-tooltip">
                                    Great!
                                </div>
                                @if(Session::has('g_kdakun2')||Session::has('g_kdakun3'))
                                    <div class="invalid-tooltip">
                                        {{Session::get('g_kdakun2')}}{{Session::get('g_kdakun3')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-7">
                                @foreach($data2 as $dt)
                                    @if ($dt->kode == $d->kode)
                                        @if ($dt->status == 'kredit')
                                            <input type="text" name="ket2" class="form-control effect-1" value="{{$dt->ket2}}" autocomplete="off" placeholder="Ex Qurban... (boleh dikosongkan)">
                                        @endif
                                    @endif
                                @endforeach
                                <span class="focus-border"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <strong>Data Buku Kas</strong>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Buku Kas</label>
                            <div class="col-sm-7">
                                @if (!empty($d->kas->bk_kas))
                                    <input name="bk_kas" list="datalistOptions2" id="exampleDataList" value="{{$d->kas->bk_kas}}" autocomplete="off" class="form-control effect-1 
                                        {{Session::has('g_bkkas1')||Session::has('g_bkkas2')?'is-invalid':''}}" type="text" placeholder="Ex BSI..." required>
                                @else
                                    <input name="bk_kas" list="datalistOptions2" id="exampleDataList" value="{{old('bk_kas')}}" autocomplete="off" class="form-control effect-1 
                                        {{Session::has('g_bkkas1')||Session::has('g_bkkas2')?'is-invalid':''}}" type="text" placeholder="Ex BSI..." required>
                                @endif
                                <datalist id="datalistOptions2">
                                    @foreach ($kas as $k)
                                        <option value="{{ucwords($k->bk_kas)}}">
                                    @endforeach
                                </datalist>
                                <span class="focus-border"></span>
                                <div class="valid-tooltip">
                                    Great!
                                </div>
                                @if(Session::has('g_bkkas1')||Session::has('g_bkkas2'))
                                    <div class="invalid-tooltip">
                                        {{Session::get('g_bkkas1')}}{{Session::get('g_bkkas2')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <strong>Data Kategori</strong>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-7">
                                <select class="effect-1 {{$errors->has('kat')?'is-invalid':''}} form-select " name="kat" required onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                    @if(!empty($d->kategori->name))
                                        <option value="{{ $d->kategori->name }}" hidden>{{ ucfirst($d->kategori->name) }}</option>
                                    @else
                                        <option value="" hidden="true">-Pilih-</option> 
                                    @endif
                                    <option value="" hidden="true">-Pilih-</option> 
                                    @forelse($kat as $k)
                                        <option value="{{ $k->name }}" {{ old('kat') == $k->name ? "selected" : "" }}>{{ ucfirst($k->name) }}</option>
                                    @empty
                                        <option value="" disabled>Silahkan tambah kategori di Tambah Kategori</option>
                                    @endforelse
                                </select>
                                <span class="focus-border"></span>
                                <div class="valid-tooltip">
                                    Great!
                                </div>
                                @error('kat')
                                    <div class="invalid-tooltip">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <strong>Nominal Uang</strong>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Jumlah Uang</label>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-6">
                                    <input type="number" min="1" name="uang" class="form-control effect-1 {{$errors->has('uang')?'is-invalid':''}}" value="{{ $d->debit }}" autocomplete="off" 
                                        placeholder="Masukkan Jumlah Uang..." required id="inputAngka"> 
                                        <span class="focus-border"></span>
                                        <div class="valid-tooltip">
                                            Great!
                                        </div>
                                        @error('uang')
                                            <div class="invalid-tooltip">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6 pt-2">
                                        Rp. <span id="showTextRibuan"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <strong>Data Gambar (Optional)</strong>
                    <div class="form-group pt-3">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Gambar</label>
                            <div class="col-sm-7">
                                <div class="card-body p-0" style="width: 300px;">
                                    <div class="wrapper">
                                        <div class="imageupload panel-default">
                                            <div class="file-tab mt-2 text-center">
                                                <label class="btn btn-outline-custom3 btn-file">
                                                    <span>Choose File</span>
                                                    <!-- The file is stored here. -->
                                                    <input type="file" name="image" accept="image/png, image/jpeg, image/jpg, image/tiff">
                                                </label>
                                                <button type="button" class="btn btn-outline-custom3 mb-2">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($d->image != 'default/default.png')
                                    <div class="form-check pt-2">
                                        <input class="form-check-input" type="checkbox" name="check">
                                        <span class="form-check-label">
                                            Kembalikan ke default 
                                            <i class="fas fa-info-circle text-secondary" style="cursor: pointer" title="Menghapus data gambar dan mengembalikannya ke gambar default."></i>
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group pt-5">
                        <div class="row">
                            <div class="col-sm-10 text-right">
                                <a type="button" class="btn btn-outline-custom" href="/main/keuangan">Cancel</a>
                                <button type="submit" class="btn btn-custom">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/convert.js"></script>
        <script src="/js/bootstrap-imageupload.js"></script>
        <script>
            var $imageupload = $('.imageupload');
            $imageupload.imageupload({                
                    imgSrc: "{{ url('/assets/'.$d->image) }}"  
                });

            $('#imageupload-disable').on('click', function() {
                $imageupload.imageupload('disable');
                $(this).blur();
            })

            $('#imageupload-enable').on('click', function() {
                $imageupload.imageupload('enable');
                $(this).blur();
            })

            $('#imageupload-reset').on('click', function() {
                $imageupload.imageupload('reset');
                $(this).blur();
            });
        </script>
    @endif
    @endforeach 
@endsection	