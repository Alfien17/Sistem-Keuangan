@extends('main')
@section('judul_halaman','Tambah Kredit')
@section('konten')
<br>
<div class="container">
    @if(Session::has('g_kredit'))
    <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_kredit')}}
    </div>
    @endif
    @if(Session::has('g2_kredit'))
    <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <i class="fas fa-exclamation-triangle"></i> {{Session::get('g2_kredit')}}
    </div>
    @endif
	<form method="post" action="/addout" enctype="multipart/form-data">
	{{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-5">
                        <input type="date" name="tanggal" class="form-control {{$errors->has('tanggal')?'is-invalid':''}}"  value="{{old('tanggal', $keuangan->tanggal ?? '')}}" >
                        @error('tanggal')
                        <div class="invalid-feedback">{{'The Tanggal field is required.'}}</div>
                        @enderror
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Kode Akun</label>
                     <div class="col-sm-5">
                         <input name="kd_akun" list="datalistOptions" id="exampleDataList" value="{{old('kd_akun')}}" autocomplete="off" class="form-control {{$errors->has('kd_akun')?'is-invalid':''}}" type="text" placeholder="Ex 1-101...">
                         <datalist id="datalistOptions">
                         @foreach ($akun as $a)
                            <option value="{{$a->kd_akun}}">{{ucwords($a->nama_akun)}}
                        @endforeach
                        </datalist>
                        @error('kd_akun')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Buku Kas</label>
                     <div class="col-sm-5">
                        <input name="bk_kas" list="datalistOptions2" id="exampleDataList" value="{{old('bk_kas')}}" autocomplete="off" class="form-control {{$errors->has('bk_kas')?'is-invalid':''}}" type="text" placeholder="Ex BSI...">
                        <datalist id="datalistOptions2">
                         @foreach ($kas as $k)
                            <option value="{{ucwords($k->bk_kas)}}">
                        @endforeach
                        </datalist>
                        @error('bk_kas')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-5">
                        <input type="text" name="ket" class="form-control {{$errors->has('ket')?'is-invalid':''}}" value="{{old('ket')}}" autocomplete="off" placeholder="Ex Qurban...">
                        @error('ket')
                        <div class="invalid-feedback">{{'The Keterangan field is required.'}}</div>
                        @enderror
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-5">
                        <select class="form-control {{$errors->has('kat')?'is-invalid':''}}" name="kat">
                            <option value="" hidden="true">-Pilih-</option> 
                            @forelse($kat as $k)
                                <option value="{{ $k->name }}" {{ old('kat') == $k->name ? "selected" : "" }}>{{ ucwords($k->name) }}</option>
                            @empty
                                <option value="" disabled>Silahkan tambah kategori di Tambah Kategori</option>
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
                <label class="col-sm-2 col-form-label">Jumlah Uang</label>
                    <div class="col-sm-5">
                        <input type="number" min="0" name="kredit" class="form-control {{$errors->has('kredit')?'is-invalid':''}}" value="{{old('kredit')}}" autocomplete="off" placeholder="Masukkan Jumlah Uang...">
                        @error('kredit')
                        <div class="invalid-feedback">{{'The Jumlah Uang field is required.'}}</div>
                        @enderror
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Gambar</label>
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
                                        <button type="button" style="border: none" class="btn btn-outline-secondary mb-2">Remove</button>
                                    </div>
                                    <div class="url-tab">
                                        <div class="input-group">
                                            <input type="text" class="form-control hasclear" placeholder="Image URL">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-outline-secondary">Submit</button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary">Remove</button>
                                        <!-- The URL is stored here. -->
                                        <input type="hidden" name="image-url">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-7 text-right">
            	<a class="btn btn-light" href="/main">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </div>
    </form>
</div>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
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
        <script type="text/javascript" src="/js/typeahead4.min.js"></script> 
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
        </script>--}}
@endsection	