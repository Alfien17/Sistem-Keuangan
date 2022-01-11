@extends('main')
@section('judul_halaman','Update | Kredit')
@section('konten')
<br>
<div class="container">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main">Home</a></li>
        <li class="breadcrumb-item text-black"><a class="text-dark" href="/main/keuangan">Rekap</a></li>
        <li class="breadcrumb-item active" aria-current="page">Update</li>
    </ol>
    </nav>
    @if(Session::has('g_upout'))
        <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_upout')}}
        </div>
    @endif
    @if(Session::has('g_upout2'))
        <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_upout2')}}
        </div>
    @endif
    @foreach($data as $d)
    <div class="row">
            <div class="col-md-7">
                <form method="post" action="/updateout/{{$d->id}}" enctype="multipart/form-data">
	            {{ csrf_field() }}
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
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
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Kode Akun</label>
                        <div class="col-sm-8">
                            @if(!empty($d->akun->kd_akun))
                                <input name="kd_akun" list="datalistOptions" id="exampleDataList" value="{{$d->akun->kd_akun}}" autocomplete="off" class="form-control effect-1 {{$errors->has('kd_akun')?'is-invalid':''}}" type="text" placeholder="Ex 1-101..." required>
                            @else
                                <input name="kd_akun" list="datalistOptions" id="exampleDataList" value="{{old('kd_akun')}}" autocomplete="off" class="form-control effect-1 {{$errors->has('kd_akun')?'is-invalid':''}}" type="text" placeholder="Ex 1-101..." required>
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
                            @error('kd_akun')
                                <div class="invalid-tooltip">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                    <label class="col-sm-3 col-form-label">Buku Kas</label>
                        <div class="col-sm-8">
                            @if (!empty($d->kas->bk_kas))
                                <input name="bk_kas" list="datalistOptions2" id="exampleDataList" value="{{$d->kas->bk_kas}}" autocomplete="off" class="form-control effect-1 {{$errors->has('bk_kas')?'is-invalid':''}}" type="text" placeholder="Ex BSI..." required>
                            @else
                                <input name="bk_kas" list="datalistOptions2" id="exampleDataList" value="{{old('bk_kas')}}" autocomplete="off" class="form-control effect-1 {{$errors->has('bk_kas')?'is-invalid':''}}" type="text" placeholder="Ex BSI..." required>
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
                            @error('bk_kas')
                                <div class="invalid-tooltip">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <input type="text" id="img" name="ket" class="form-control effect-1" autocomplete="off" placeholder="Ex Qurban... (boleh dikosongkan)">
                            <span class="focus-border"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-8">
                            <select class="form-select effect-1 {{$errors->has('kat')?'is-invalid':''}}" name="kat" required onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=5;' onblur="this.size=0;">
                                @if(!empty($d->kategori->name))
                                    <option value="{{ $d->kategori->name }}" hidden>{{ $d->kategori->name }}</option>
                                @else
                                    <option value="" hidden="true">-Pilih-</option> 
                                @endif
                                @forelse($kat as $k)
                                    <option value="{{ $k->name }}" {{ old('kat') == $k->name ? "selected" : "" }}>{{ ucwords($k->name) }}</option>
                                @empty
                                    <option value="" disabled>Lakukan tambah kategori dahulu</option>
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
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Jumlah Uang</label>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" min="1" name="kredit" class="form-control effect-1 {{$errors->has('kredit')?'is-invalid':''}}" value="{{ $d->kredit }}" autocomplete="off" 
                                        placeholder="Masukkan Jumlah Uang..." required id="inputAngka"> 
                                    <span class="focus-border"></span>
                                    <div class="valid-tooltip">
                                        Great!
                                    </div>
                                    @error('kredit')
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
                @if(!empty($d->akun->kd_akun))
                    <div class="form-group">
                        <div class="row">
                            <strong class="col-sm-3 col-form-label">Batas Kredit</strong>
                            <div class="col-sm-8 mt-2">
                                @if (empty($total))
                                    @if($d->akun->check != 'true')
                                        <strong class="col-form-label">Rp. 0</strong>
                                    @endif
                                @else
                                    <strong class="col-form-label">Rp. {{number_format((float)$total+$d->kredit)}}</strong> 
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <strong class="col-sm-3 col-form-label">Saldo Akun{{$d->akun->kd_akun}}</strong>
                            <div class="col-sm-8 mt-2">
                                @if (empty($total))
                                    <strong class="col-form-label">Rp. 0</strong> 
                                @else
                                    <strong class="col-form-label">Rp. {{number_format((float)$total)}}</strong>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <div class="row">
                        <strong class="col-sm-3 col-form-label">Saldo Total</strong>
                        <div class="col-sm-8 mt-2">
                            <strong class="col-form-label">Rp. {{number_format((float)$saldo)}}</strong> 
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-11 text-right">
                            <a type="button" class="btn btn-outline-custom" href="/main/keuangan">Cancel</a>
                            <button type="submit" class="btn btn-custom">Update</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>

            <div class="col-md-5">
                <form action="/eimage/{{$d->id}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Gambar</label>
                            <div class="col-sm-5">
                                <div class="card-body p-0" style="width: 300px;">
                                    <div class="wrapper">
                                        <div class="imageupload panel-default">
                                            <div class="file-tab mt-2 text-center">
                                                <label class="btn btn-outline-custom3 btn-file">
                                                    <span>Choose File</span>
                                                    <!-- The file is stored here. -->
                                                    <input type="file" name="image" accept="image/png, image/jpeg, image/jpg, image/tiff">
                                                </label>
                                                <button type="button" class="btn btn-outline-custom3 mb-2">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="text-right col-sm-11">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a type="button" class="btn btn-outline-custom3" data-bs-toggle="modal" data-bs-target="#delete{{$d->id}}">Remove</a>
                                    <button class="btn btn-outline-custom3">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Modal Delete --}}
                <div class="modal fade" id="delete{{$d->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">Anda yakin ingin menghapus gambar dan mengembalikannya ke gambar default?</div>
                            <div class="modal-footer">
                                <form action="/dimage/{{$d->id}}" method="post">
                                    @csrf
                                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-custom">Yes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(Session::has('g_img'))
                    <div class="alert alert-light alert-dismissible text-danger" role="alert" id="liveAlert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_img')}}
                    </div>
                @endif
                @if(Session::has('s_eimg'))
                    <div class="alert alert-light alert-dismissible text-success" role="alert" id="liveAlert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="fas fa-check-circle"></i> {{Session::get('s_eimg')}}
                    </div>
                @endif
                @if(Session::has('s_dimg'))
                    <div class="alert alert-light alert-dismissible text-success" role="alert" id="liveAlert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="fas fa-check-circle"></i> {{Session::get('s_dimg')}}
                    </div>
                @endif
            </div>
    </div>
</div>
    
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/convert.js"></script>
        <script src="/js/bootstrap-imageupload.js"></script>
        <script>
            var $imageupload = $('.imageupload');
            $imageupload.imageupload({ imgSrc: "{{ url('/assets/'.$d->image) }}" });

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
    @endforeach 
@endsection	