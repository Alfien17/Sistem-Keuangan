@extends('main')
@section('judul_halaman','Biaya')
@section('konten')
    <br>
    <div class="container">
        <form method="post" action="/postbiaya" enctype="multipart/form-data" class="pb-2">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-5">
                                <input type="date" name="dari" class="form-control effect-1" required 
                                @if(!empty($from)) value="{{$from}}" @endif>
                                <span class="focus-border3"></span>
                            </div>
                            <div class="col-2 text-center">
                                <label class="col-form-label">Ke</label>
                            </div>
                            <div class="col-5">
                                <input type="date" name="ke" class="form-control effect-1" required 
                                @if(!empty($to)) value="{{$to}}" @endif>
                                <span class="focus-border3"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-7 text-right">
                        <a type="button" class="btn btn-outline-custom" href="/main/pendapatan">Cancel</a>
                        <button type="submit" class="btn btn-custom">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="d-flex justify-content-between">
            <div class="dropdown">
                <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Toggle Column
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="toggle-vis dropdown-item cursor" data-column="0">#</a></li>
                    <li><a class="toggle-vis dropdown-item cursor" data-column="1">Tanggal</a></li>
                    <li><a class="toggle-vis dropdown-item cursor" data-column="2">Kode Akun</a></li>
                    <li><a class="toggle-vis dropdown-item cursor" data-column="3">Nama Akun</a></li>
                    <li><a class="toggle-vis dropdown-item cursor" data-column="4">Buku Kas</a></li>
                    <li><a class="toggle-vis dropdown-item cursor" data-column="5">Cash/Cashless</a></li>
                    <li><a class="toggle-vis dropdown-item cursor" data-column="6">Rp.</a></li>
                </ul>
            </div>
        </div>
        <div class="card shadow mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-hover display nowrap" cellspacing="0" width="100%">
                        <thead class="table-control text-center">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th data-priority="1">Kode Akun</th>
                                <th>Nama Akun</th>
                                <th data-priority="3">Buku Kas</th>
                                <th>Cash/Cashless</th>
                                <th data-priority="2">Rp.</th>
                            </tr>
                        </thead>
                        <tbody class=" text-left">
                        <?php $id = 1 ?>
                        @forelse($biaya as $k)
                            <tr>
                                <td>{{$id++}}</td>
                                <td style="cursor:pointer" title="Diubah pada {{$k->updated_at}}">{{date('d-m-Y', strtotime($k->tanggal))}}</td>
                                <td>{{ucwords($k->akun->kd_akun)}}</td>
                                <td>{{ucwords($k->akun->nama_akun)}}</td>
                                <td>{{ucwords($k->kas->bk_kas)}}</td>
                                <td>{{ucwords($k->kas->tipe)}}</td>
                                <td>Rp. {{number_format((float)$k->total)}}</td>
                        @empty
                            <tr class="text-center">
                                <td colspan="7">
                                    <div class="content m-5">
                                        <div class="icon"><i class="far fa-sad-tear"></i></div>
                                        <div class="text2 ml-4">Data Kosong.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" style="text-align:right">Total :</th>
                                <th>Rp. {{number_format((float)$total)}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                language: {
                    search: "",
                    searchPlaceholder: "Search..."
                },
                responsive: true,
                "order": [[ 0, "asc" ]],
                dom: 
                "<'row'<'col-2 text-left'l><'col-10 text-right 'f>>" +
                "<'row'<'col-sm-12'tr>>"+
                "<'row'<'col-md-6'i><'col-md-6'p>>",
                lengthMenu:[
                    [10,25,50,100,-1],
                    [10,25,50,100,"All"]
                ]
            } );
            
            table.buttons().container()
            .appendTo( '#table_wrapper .col-md-5:eq(0)' );

            $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
                // Get the column API object
                var column = table.column( $(this).attr('data-column') );
                // Toggle the visibility
                column.visible( ! column.visible() );
            } );
        } );
    </script>
@endsection