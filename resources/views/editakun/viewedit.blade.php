@extends('main')
@section('judul_halaman','Akun')
@section('konten')
<br>
<div class="container">
    @if (count($errors)>0)
    <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
        <ul style="list-style:none">
            @foreach($errors->all() as $error)
            <li><span class="fas fa-exclamation-triangle"></span>
                {{$error}}
            </li>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="image_area">
                                <form method="post" action="{{route('imageakun',Auth::user()->id ??'')}}" enctype="multipart/form-data">
                                    @csrf
                                    <label for="upload_image">
                                        <img src="{{url('/assets/'.Auth::user()->image ??'')}}" id="uploaded_image" class="img img-responsive rounded-circle" width="200" height="200"/>
                                        <div class="overlay">
                                            <div class="text">Click to Change Profile Image</div>
                                        </div>
                                        <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                                    </label>

                                    {{-- Modal Image --}}
                                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Preview Image</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="" id="sample_image" class="w-25 h-25" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" id="crop" class="btn btn-outline-primary">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="ml-5 row mb-3">
                        <div class="col-auto">
                           <a href="/dprofile/{{Auth::user()->id ??''}}" class="btn btn-outline-secondary border-0">Remove</a> 
                        </div>
                    </div>
                    @if(Session::has('g_img'))
                    <div class="alert alert-light alert-dismissible text-danger" role="alert" id="liveAlert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <small><i class="fas fa-exclamation-triangle"></i> {{Session::get('g_img')}}</small>
                    </div>
                    @endif
                    @if(Session::has('s_eimg'))
                    <div class="alert alert-light alert-dismissible text-success" role="alert" id="liveAlert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <small><i class="fas fa-check-circle"></i> {{Session::get('s_eimg')}}</small>
                    </div>
                    @endif
                    @if(Session::has('s_dimg'))
                    <div class="alert alert-light alert-dismissible text-success" role="alert" id="liveAlert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <small><i class="fas fa-check-circle"></i> {{Session::get('s_dimg')}}</small>
                    </div>
                @endif
                </div>
                <div class="col-8">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            {{--  form  --}}
                                <form method="post" action="/posteditakun" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-5">
                                                <input type="text" name="name" class="teks form-control form-control2" required="required" value="{{Auth::user()->name ??''}}" autocomplete="off" placeholder="Nama Lengkap">
                                                <input type="hidden" name="id" value="{{Auth::user()->id ??''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-5"><input type="email" name="email" class="teks form-control form-control2" required="required" value="{{Auth::user()->email ??''}}" autocomplete="off" placeholder="Email"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-7"><a style="cursor: pointer;" title="Lupa Password" data-bs-toggle="modal" data-bs-target="#password" class="form-control-plaintext pl-2">Lupa Password?</a></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Telepon</label>
                                            <div class="col-sm-5"><input type="number" name="telp" class="teks form-control form-control2"  value="{{Auth::user()->telp ??''}}" autocomplete="off" placeholder="Nomor Telepon"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-5"><textarea name="al_detail" class="teks form-control form-control2" placeholder="Nama jalan, gedung, nomor rumah">{{Auth::user()->al_detail ??''}}</textarea></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-7 text-right">
                                                <a class="btn btn-light" href="/main/editakun/{{Auth::user()->id ??''}}">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- Modal Verifikasi --}}
    <div class="modal fade" id="password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verifikasi Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/password" enctype="multipart/form-data">
                    {{ csrf_field() }}   
                        <div class="form-group">
                            <div class="row">
                                <label class="col-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" readonly value="{{Auth::user()->email ??''}}">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-primary">Kirim Link</button>
                </div>
            </form>
            </div>
        </div>
    </div>
<script src="/js/jquery.min.js"></script>
{{-- <script src="https://unpkg.com/dropzone@5.9.3/dist/dropzone.js"></script>
<script src="https://unpkg.com/cropperjs@1.5.12/dist/cropper.js"></script> --}}
<script>
    $(document).ready(function() {
        var $modal = $('#modal');
        var image = document.getElementById('sample_image');
        var cropper;
        $('#upload_image').change(function(event) {
            var files = event.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function(event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });
        $('#crop').click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $.ajax({
                        url: 'imageakun/{{Auth::user()->id ??''}}',
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'images='+base64data,
                        success: function(data) {
                            $modal.modal('hide');
                            $('#uploaded_image').attr('src', data);
                        }
                    });
                };
            });
        });
    });
</script>
@endsection	