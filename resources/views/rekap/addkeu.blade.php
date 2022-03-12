@extends('main')
@section('judul_halaman','Tambah Data Keuangan')
@section('konten')
<br>
<div class="container">
    @if(Session::has('g_addkeu'))
        <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_addkeu')}}
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <form method="post" action="/tambah" enctype="multipart/form-data">
            {{ csrf_field() }}
                <strong>Data Tanggal</strong>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-7">
                            <input type="date" name="tanggal" class="form-control effect-1 {{$errors->has('tanggal')?'is-invalid':''}}"  value="{{old('tanggal', $keuangan->tanggal ?? '')}}" required>
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
                            <input name="kd_akun1" list="datalistOptions" id="exampleDataList" value="{{old('kd_akun1')}}" autocomplete="off" class="form-control effect-1 
                                {{Session::has('g_kdakun1')||Session::has('g_kdakun3')?'is-invalid':''}}" type="text" placeholder="Ex 1-101...(Untuk Debit)" required>
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
                            <input type="text" name="ket1" class="form-control effect-1" value="{{old('ket1')}}" autocomplete="off" placeholder="Ex Qurban... (boleh dikosongkan)">
                            <span class="focus-border"></span>
                        </div>
                    </div>
                </div>
                <strong>Data Kredit</strong>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Kode Akun</label>
                        <div class="col-sm-7">
                            <input name="kd_akun2" list="datalistOptions" id="exampleDataList" value="{{old('kd_akun2')}}" autocomplete="off" class="form-control effect-1 
                                {{Session::has('g_kdakun2')||Session::has('g_kdakun3')?'is-invalid':''}}" type="text" placeholder="Ex 1-101...(Untuk Kredit)" required>
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
                            <input type="text" name="ket2" class="form-control effect-1" value="{{old('ket2')}}" autocomplete="off" placeholder="Ex Qurban... (boleh dikosongkan)">
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
                            <input name="bk_kas" list="datalistOptions2" id="exampleDataList" value="{{old('bk_kas')}}" autocomplete="off" class="form-control effect-1 
                                {{Session::has('g_bkkas1')||Session::has('g_bkkas2')?'is-invalid':''}}" type="text" placeholder="Ex BSI..." required>
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
                                <input type="number" min="1" name="uang" class="form-control effect-1 {{$errors->has('uang')?'is-invalid':''}}" value="{{old('uang')}}" autocomplete="off" 
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
                        </div>
                    </div>
                </div>
                <div class="form-group pt-5">
                    <div class="row">
                        <div class="col-sm-10 text-right">
                            <a type="button" class="btn btn-outline-custom" href="/main/keuangan/tambah">Cancel</a>
                            <button type="submit" class="btn btn-custom">Submit</button>
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
            $imageupload.imageupload({ imgSrc: "" });

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
@endsection	