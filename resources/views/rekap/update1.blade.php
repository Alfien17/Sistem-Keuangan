@extends('main')
@section('judul_halaman','Update')
@section('konten')
<br>
<div class="container">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item text-black"><a href="/main">Home</a></li>
        <li class="breadcrumb-item text-black"><a href="/main/keuangan">Rekap</a></li>
        <li class="breadcrumb-item active" aria-current="page">Update</li>
    </ol>
    </nav>
    @if(Session::has('g_upin'))
        <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_upin')}}
        </div>
    @endif
    @if(Session::has('g_upin2'))
        <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_upin2')}}
        </div>
    @endif
    @foreach($data as $d)
    <div class="row">
            <div class="col-md-7">
                <form method="post" action="/updatein/{{$d->id}}" enctype="multipart/form-data">
	            {{ csrf_field() }}
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="date" name="tanggal" class="form-control {{$errors->has('tanggal')?'is-invalid':''}}"  value="{{$d->tanggal}}" >
                            <input type="hidden" name="id" value="{{$d->id}}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{'The Tanggal field is required.'}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Kode Akun</label>
                        <div class="col-sm-8">
                            <input name="kd_akun" list="datalistOptions" id="exampleDataList" 
                                @forelse ($akun as $a)
                                    @if($d->akun_id == $a->id)
                                        value="{{$a->kd_akun}}" 
                                    @endif
                                @empty
                                    placeholder="Lakukan tambah akun dahulu" disabled
                                @endforelse
                            autocomplete="off" class="form-control {{$errors->has('kd_akun')?'is-invalid':''}}" type="text" placeholder="Ex 1-101...">
                            <datalist id="datalistOptions">
                                @foreach ($akun as $a)
                                    <option value="{{$a->kd_akun}}">{{ucwords($a->nama_akun)}}
                                @endforeach
                            </datalist>
                             @error('kd_akun')
                                <div class="invalid-feedback">{{'The Kode Akun field is required.'}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                    <label class="col-sm-3 col-form-label">Buku Kas</label>
                        <div class="col-sm-8">
                            <input name="bk_kas" list="datalistOptions2" id="exampleDataList" 
                                @forelse ($kas as $a)
                                    @if($d->kas_id == $a->id)
                                        value="{{$a->bk_kas}}" 
                                    @endif
                                @empty
                                    placeholder="Lakukan tambah buku kas dahulu" disabled
                                @endforelse
                            autocomplete="off" class="form-control {{$errors->has('bk_kas')?'is-invalid':''}}" type="text" placeholder="Ex BSI...">
                            <datalist id="datalistOptions2">
                                @foreach ($kas as $k)
                                    <option value="{{ucwords($k->bk_kas)}}">
                                @endforeach
                            </datalist>
                            @error('bk_kas')
                                <div class="invalid-feedback">{{'The Buku Kas field is required.'}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <input type="text" id="img" name="ket" class="form-control {{$errors->has('ket')?'is-invalid':''}}" value="{{$d->ket}}" autocomplete="off" placeholder="Ex Qurban...">
                            @error('ket')
                                <div class="invalid-feedback">{{'The Keterangan field is required.'}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-8">
                            <select class="form-control {{$errors->has('kat')?'is-invalid':''}}" name="kat">
                                @foreach($kat as $k)
                                    @if($d->kat_id == $k->id)
                                        <option value="{{ $k->name }}" hidden>{{ $k->name }}</option>
                                    @endif
                                @endforeach
                                @forelse($kat as $k)
                                    <option value="{{ $k->name }}" {{ old('kat') == $k->name ? "selected" : "" }}>{{ ucwords($k->name) }}</option>
                                @empty
                                    <option value="" disabled>Lakukan tambah kategori dahulu</option>
                                @endforelse
                            </select>
                            @error('kat')
                                <div class="invalid-feedback">{{'The Kategori field is required.'}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Jumlah Uang</label>
                        <div class="col-sm-8">
                            <input type="number" min="0" name="debit" class="form-control {{$errors->has('debit')?'is-invalid':''}}" value="{{$d->debit}}" autocomplete="off" placeholder="Masukkan Jumlah Uang...">
                            @error('debit')
                                <div class="invalid-feedback">{{'The Jumlah Uang field is required.'}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                @foreach ($akun as $a)
                    @if($d->akun_id == $a->id)
                        <div class="form-group">
                            <div class="row">
                                <strong class="col-sm-3 col-form-label">
                                    Saldo Akun 
                                    {{$a->kd_akun}}
                                </strong>
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
                @endforeach
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
                            <a class="btn btn-light" href="/main/keuangan">Cancel</a>
                            <input type="submit" class="btn btn-primary" value="Update">
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
                                            <label class="btn btn-outline-secondary btn-file" style="border: none">
                                                <span>Choose File</span>
                                                <!-- The file is stored here. -->
                                                <input type="file" name="image" accept="image/png, image/jpeg, image/jpg, image/tiff">
                                            </label>
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
                                <a class="btn btn-outline-secondary" style="border: none" href="/dimage/{{$d->id}}">Remove</a>
                                <button type="submit" class="btn btn-outline-secondary" style="border: none">Save</button>
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
        </form>
    </div>
</div>
    
        <script type="text/javascript" src="/js/jquery.min.js"></script>
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
        {{-- <script type="text/javascript" src="/js/typeahead2.min.js"></script>
        <script type="text/javascript">
            const typeahead = document.querySelector(".typeahead");
            var path1 = "{{ route('autocompleteakun2') }}";
            if (typeahead) {  
                $(typeahead).typeahead({
                source:  function (terms, process) 
                {
                return $.get(path1, { terms: terms }, function (akun) {
                    return process(akun);
                    });
                }
                });
            }
        </script>  
        <script type="text/javascript" src="/js/typeahead.min.js"></script> 
        <script type="text/javascript">
            const typeahead2 = document.querySelector(".typeahead2");
            var path = "{{ route('autocompletekas') }}";
            if (typeahead2) { 
            $(typeahead2).typeahead({
            source:  function (terms, process) 
            {
            return $.get(path, { terms: terms }, function (data) {
                return process(data);
                });
            }
            });
        }
        </script>  --}}
    @endforeach 
@endsection	