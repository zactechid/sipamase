<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- ngrok --}}
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ $title }}</title>
    {{-- template style --}}
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    {{-- datatables --}}
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    {{-- my style --}}
    <link rel="icon" href="{{ asset('images') }}/logo.png" type="image/gif" sizes="30x30">
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: #F4F6F9;">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('images') }}/logo.png" alt="AdminLTELogo" width="150">
        </div>

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 mt-3">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik --}}
        <div class="container-fluid">
                <div class="d-flex flex-wrap">
                    <div class="col-md">
                        <div class="card card-success">
                            <div class="card-header bg-success">
                                <h3 class="card-title">Total Harmonisasi {{ $pemrakarsa }}</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" style="min-height: 340px"></canvas>
                            </div>
                        </div>
                         <div class="card card-success">
                            <div class="card-header bg-success">
                                <h3 class="card-title">Status Penyampaian Harmonisasi {{ $pemrakarsa }}</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart2"style="min-height: 340px"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="card card-info">
                            <div class="card-header bg-info">
                                <h3 class="card-title">Tabel {{ $pemrakarsa }}</h3>
                            </div>
                            <div class="card-body">
                                <table class="dataTable table table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Pemrakarsa</th>
                                            <th>Tanggal Surat</th>
                                            <th>Posisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->judul }}</td>
                                                <td>{{ $item->pemrakarsa->nama }}</td>
                                                 <td>{{ date('d-m-Y'), strtotime($item->tanggal) }}</td>
                                                @if ($item->padministrasi->nama == 'Pengajuan')
                                                    <td><p class="badge badge-info p-1">{{ $item->padministrasi->nama }}</p></td>
                                                @elseif ($item->padministrasi->nama == 'Administrasi Dan Analisis Konsep')
                                                    <td><p class="badge badge-secondary p-1">{{ $item->padministrasi->nama }}</p></td>
                                                @elseif ($item->padministrasi->nama == 'Rapat Harmonisasi')
                                                    <td><p class="badge badge-danger p-1">{{ $item->padministrasi->nama }}</p></td>
                                                @elseif ($item->padministrasi->nama == 'Penyampaian Harmonisasi' || $item->padministrasi->nama == 'Selesai Harmonisasi')
                                                    <td><p class="badge badge-success p-1">{{ $item->padministrasi->nama }}</p></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        {{-- fooer --}}
        <div style="position: absolute;bottom: 0; left:10; right: 0;">
            <p style="color: #334155;">&copy; Copyright <strong>SIPAMMASE.</strong> All rights reserved</p>
        </div>

{{-- template script --}}
<script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('template') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('template') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="{{ asset('template') }}/dist/js/adminlte.js"></script>
<script src="{{ asset('template') }}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
{{-- datatables --}}
<script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
{{-- chart --}}
<script src="{{ asset('template') }}/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('template') }}/dist/js/demo.js"></script>

<script>
    $(function () {
        $(".dataTable").DataTable();
    });

    // chart
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
            data : {
                datasets: [{
                    data: [{{ $Pengajuan }}, {{ $Administrasi }}, {{ $Rapat }}, {{ $Penyampaian }}],
                    backgroundColor: [
                        'rgb(23,162,184)',
                        'rgb(108,117,125)',
                        'rgb(220,53,69)',
                        'rgb(40,167,69)'
                    ],
                }],

                labels: [
                    'Pengajuan',
                    'Administrasi',
                    'Rapat',
                    'Penyampaian'
                ]
            },
        options: {
            maintainAspectRatio: false,
            legend: {
                     display: false,
                 },
             scales: {
                 yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            }
        }
    });
    var ctx2 = document.getElementById('myChart2');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
            data : {
                datasets: [{
                    data: [{{ $selesai_harmonisasi }}, {{ $pengembalian_disempurnakan }}, {{ $pengembalian_dilanjutkan }}],
                    backgroundColor: [
                        'rgb(23,162,184)',
                        'rgb(108,117,125)',
                        'rgb(220,53,69)',
                    ],
                }],

                labels: [
                    'Selesai Harmonisasi',
                    'Pengembalian Untuk Disempurnakan',
                    'Pengembalian Untuk Tidak Dilanjutkan'
                ]
            },
        options: {
            maintainAspectRatio: false,
            legend: {
                     display: false,
                 },
             scales: {
                 xAxes: [
                     {
                         ticks: {
                             callback: function(label) {
                                 if (/\s/.test(label)) {
                                     return label.split(' ')
                                 } else {
                                     return label;
                                 }
                             }
                         }
                     }
                     ],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            }
        }
    });
</script>
</body>
</html>