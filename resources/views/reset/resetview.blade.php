@extends('main')
@section('judul_halaman','Reset Data')
@section('konten')
<br>
<div class="container">
    @if(Session::has('s_dakun'))
        <div class="alert alert-success alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-check-circle"></i> {{Session::get('s_dakun')}}
        </div>
    @endif
    @if(Session::has('s_dkas'))
        <div class="alert alert-success alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-check-circle"></i> {{Session::get('s_dkas')}}
        </div>
    @endif
    @if(Session::has('s_dkat'))
        <div class="alert alert-success alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-check-circle"></i> {{Session::get('s_dkat')}}
        </div>
    @endif
    @if(Session::has('s_dkeu'))
        <div class="alert alert-success alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-check-circle"></i> {{Session::get('s_dkeu')}}
        </div>
    @endif
    @if(Session::has('g_delete'))
        <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-exclamation-triangle"></i> {{Session::get('g_delete')}}
        </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="bd-callout">
                <h5>Reset Data Akun</h5>
                <button role="button" title="Reset Data Akun" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteakun">Reset</button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bd-callout">
                <h5>Reset Data Buku Kas</h5>
                <button role="button" title="Reset Data Buku Kas" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletekas">Reset</button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bd-callout">
                <h5>Reset Data Kategori</h5>
                <button role="button" title="Reset Data Kategori" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletekat">Reset</button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bd-callout">
                <h5>Reset Data Keuangan</h5>
                <button role="button" title="Reset Data Keuangan" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletekeu">Reset</button>
            </div>
        </div>
    </div>

    {{-- Modal Reset --}}
    <div class="modal fade" id="deleteakun" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                Anda yakin ingin reset data akun?<br>
                Data akan hilang secara permanen.
            </div>
                <div class="modal-footer">
                    <form action="/deleteakun" method="post">
                        @csrf
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    <div class="modal fade" id="deletekas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                Anda yakin ingin reset data buku kas?<br>
                Data akan hilang secara permanen.
            </div>
                <div class="modal-footer">
                    <form action="/deletekas" method="post">
                        @csrf
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    <div class="modal fade" id="deletekat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                Anda yakin ingin reset data kategori?<br>
                Data akan hilang secara permanen.
            </div>
                <div class="modal-footer">
                    <form action="/deletekat" method="post">
                        @csrf
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    <div class="modal fade" id="deletekeu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i> Alert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                Anda yakin ingin reset data keuangan?<br>
                Data akan hilang secara permanen.
            </div>
                <div class="modal-footer">
                    <form action="/deletekeu" method="post">
                        @csrf
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 

</div>
@endsection	