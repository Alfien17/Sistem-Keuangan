@extends('main')
@section('judul_halaman','Pilih Buku Kas')
@section('konten')
<br>
<div class="container">
	<form method="post" action="/main/laporan-kas/view" enctype="multipart/form-data">
	{{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 col-form-label">Buku Kas</label>
                     <div class="col-sm-5">
                         <input name="bk_kas" list="datalistOptions" id="exampleDataList" value="{{old('bk_kas')}}" autocomplete="off" class="form-control effect-1 {{$errors->has('bk_kas')?'is-invalid':''}}" type="text" placeholder="Ex BSI..." required>
                         <span class="focus-border"></span>
                         <datalist id="datalistOptions">
                         @foreach ($kas as $k)
                            <option value="{{$k->bk_kas}}">
                        @endforeach
                        </datalist>
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
                <label class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-6">
                            <select class="effect-1 {{$errors->has('bulan')?'is-invalid':''}} form-select " name="bulan" required onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=5;' onblur="this.size=0;">
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
                            <select class="effect-1 {{$errors->has('tahun')?'is-invalid':''}} form-select " name="tahun" required onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=5;' onblur="this.size=0;">
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
                    <a type="button" class="btn btn-outline-custom" href="/main/laporan-kas">Cancel</a>
                    <button type="submit" class="btn btn-custom">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection	