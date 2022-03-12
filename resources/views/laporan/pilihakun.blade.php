@extends('main')
@section('judul_halaman','Pilih Akun')
@section('konten')
<br>
<div class="container">
	<form method="post" action="/main/laporan-akun/view" enctype="multipart/form-data">
	{{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Kode Akun</label>
                <div class="col-sm-5">
                    <input name="kd_akun" list="datalistOptions" id="exampleDataList" value="{{old('kd_akun')}}" autocomplete="off" class="form-control effect-1 {{$errors->has('kd_akun')?'is-invalid':''}}" type="text" placeholder="Ex 1-101..." required>
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
                <label class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-6">
                            <select class="effect-1 {{$errors->has('bulan')?'is-invalid':''}} form-select " name="bulan" required onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                <option value="" hidden="true">-Pilih Bulan-</option> 
                                @foreach($month as $m)
                                <option value="{{($m->month)}}">{{($m->month)}}</option>
                                @endforeach
                                <option disabled>___________________</option>
                                <option value="all">Tampilkan Semua</option>
                            </select>
                            <span class="focus-border"></span>
                            <div class="valid-tooltip">
                                Great!
                            </div>
                            @error('bulan')
                                <div class="invalid-tooltip">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <select class="effect-1 {{$errors->has('tahun')?'is-invalid':''}} form-select " name="tahun" required onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                <option value="" hidden="true">-Pilih Tahun-</option> 
                                @foreach($year2 as $y)
                                <option value="{{($y->year2)}}">{{($y->year2)}}</option>
                                @endforeach
                                <option disabled>___________________</option>
                                <option value="all">Tampilkan Semua</option>
                            </select>
                            <span class="focus-border"></span>
                            <div class="valid-tooltip">
                                Great!
                            </div>
                            @error('tahun')
                                <div class="invalid-tooltip">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="form-group">
            <div class="row">
                <div class="col-sm-7 text-right">
                    <a type="button" class="btn btn-outline-custom" href="/main/laporan-akun">Cancel</a>
                    <button type="submit" class="btn btn-custom">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection	