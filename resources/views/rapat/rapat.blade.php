@extends('partviewAdmin.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6 mt-3">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter</h5>
                        <div class="d-flex flex-wrap">
                            {{-- filtering --}}
                            <form action="" method="POST">
                            @csrf
                            <div class="d-flex flex-wrap mt-3">
                                <div class="form-group col-auto">
                                    <label for="tahun">Tahun</label>
                                    <select class="form-control filter" id="filter_tahun" name="tahun">
                                        @if ($post_tahun)
                                            <option value="{{ $post_tahun }}" selected>{{ $post_tahun }}</option>
                                        @else
                                            <option value="" selected></option>
                                        @endif

                                        @foreach ($tahun as $item)
                                            @if ($item->no == $post_tahun)
                                                <option value="" class="d-none"></option>
                                            @else
                                                <option value="{{ $item->no }}">{{ $item->no }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                    <div class="form-group col-auto">
                                        <label for="harmonisasi">Harmonisasi</label>
                                        <select class="form-control filter" id="filter_harmonisasi" name="harmonisasi">
                                            @if ($post_harmonisasi)
                                                <option value="{{ $post_harmonisasi }}" selected>{{ $post_harmonisasi }}</option>
                                            @else
                                                <option value="" selected></option>
                                            @endif

                                            @foreach ($rancangan as $item)
                                                @if ($item->nama == $post_harmonisasi)
                                                    <option value="" class="d-none"></option>
                                                @else
                                                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-auto">
                                        <label for="pemrakarsa">Pemrakarsa</label>
                                        <select class="form-control filter" id="filter_pemrakarsa" name="pemrakarsa">
                                            @if ($post_pemrakarsa)
                                                <option value="{{ $post_pemrakarsa }}" selected>{{ $post_pemrakarsa }}</option>
                                            @else
                                                <option value="" selected></option>
                                            @endif

                                            @foreach ($pemrakarsa as $item)
                                                @if ($item->nama == $post_pemrakarsa)
                                                    <option value="" class="d-none"></option>
                                                @else
                                                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-secondary ml-2"><i class="fas fa-filter"></i> Filter</button>
                                <a href="/rapat" class="btn btn-danger ml-2"><i class="fas fa-filter"></i> Reset</a>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="dataTable table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pemrakarsa</th>
                                    <th>Tanggal Surat</th>
                                    <th>Tanggal & Waktu Permohonan</th>
                                    <th>Waktu Permohonan</th>
                                    <th>Dokumen Pengajuan</th>
                                    <th>Dokumen Kegiatan</th>
                                    <th>Status</th>
                                    <th>Posisi</th>
                                    <th>Proses</th>
                                    <th>Pemegang Draft</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($harmonisasi as $item)
                                  <?php
                                      if (!empty($item->waktu_selesai)) {
                                        $now = new DateTime($item->waktu_selesai);
                                      } else {
                                          $now = new DateTime();
                                      }
                                      $target = new DateTime($item->created_at);
                                      $interval = $now->diff($target);
                                      $hari = $interval->format('%d');
                                      $jam = $interval->format('%h');
                                      $menit = $interval->format('%i');
                                      $detik = $interval->format('%s');
                                      $hasil_durasi = '';
                                      if ($hari > 0) {
                                          $hasil_durasi .= $hari .' Hari ';
                                      }

                                    ?>
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ $item->pemrakarsa->nama }}</td>
                                        <td>{{ date('d-m-Y'), strtotime($item->tanggal) }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
                                        <td>{{ $hasil_durasi }}</td>

                                        {{-- dokumen pengajuan --}}
                                        @if ($item->surat_pemda_id == null && $item->surat_dprd_id == null && $item->surat_rperkada_id == null)
                                            <td><p class="badge badge-danger">Belum ada dokumen</p></td>
                                        @elseif($item->surat_pemda_id !== null)
                                            <td>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_pemda->docx1 }}" target="_blank">Surat Permohonan. <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_pemda->docx2 }}" target="_blank">NA. <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_pemda->docx3 }}" target="_blank">SK Tim. <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_pemda->docx4 }}" target="_blank">DRAFT RANPERDA (PDF). <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_pemda->docx5 }}" target="_blank">DRAFT RANPERDA (DOC). <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_pemda->docx6 }}" target="_blank">SK Propemperda/SK Bersama jika di Luar. <i class="fas fa-download"></i></a>
                                            </td>>
                                        @elseif($item->surat_dprd_id !== null)
                                            <td>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_dprd->docx1 }}" target="_blank">Surat Permohonan. <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_dprd->docx2 }}" target="_blank">NA. <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_dprd->docx3 }}" target="_blank">DRAFT RANPERDA. <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_dprd->docx4 }}" target="_blank">SK Propemperda. <i class="fas fa-download"></i></a>
                                            </td>
                                        @elseif($item->surat_rperkada_id !== null)
                                            <td>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_rperkada->docx1 }}" target="_blank">Surat Permohonan. <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_rperkada->docx2 }}" target="_blank">Penjelasan/Keterangan. <i class="fas fa-download"></i></a>
                                                <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->surat_rperkada->docx3 }}" target="_blank">DRAFT RANPERKADA. <i class="fas fa-download"></i></a>
                                            </td>
                                        @endif

                                        {{-- dokumen kegiatan --}}
                                        @if ($item->doc_administrasi_id == null && $item->doc_rapat_id == null && $item->doc_penyampaian_id == null)
                                            <td><p class="badge badge-danger">Belum ada dokumen</p></td>
                                        @else
                                            <td>
                                                @if ($item->doc_administrasi->docx1 !== null)
                                                    <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->doc_administrasi->docx1 }}" target="_blank">Dokumen LPA/AK. <i class="fas fa-download"></i></a>
                                                @else
                                                    <a class="badge badge-danger mr-2 mt-1 p-1" target="_blank"> Belum ada dokumen</a>
                                                @endif

                                                @if ($item->doc_rapat_id == null)
                                                    <a class="badge badge-danger mr-2 mt-1 p-1" target="_blank"> Belum ada dokumen</a>
                                                @elseif($item->doc_rapat->docx1 !== null)
                                                    <a class="badge badge-info mr-2 mt-1 p-1" href="{{ secure_url('storage') }}/{{ $item->doc_rapat->docx1 }}" target="_blank">Dokumen Kegiatan. <i class="fas fa-download"></i></a>
                                                @else
                                                    <a class="badge badge-danger mr-2 mt-1 p-1" target="_blank"> Belum ada dokumen</a>
                                                @endif
                                            </td>
                                        @endif

                                        {{-- stauts --}}
                                        @if ($item->status_rapat == 'Di Tolak')
                                            <td class="text-center">
                                                <p class="badge badge-danger">Di Tolak</p>
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <p class="badge badge-primary">Di Proses</p>
                                            </td>
                                        @endif

<!--
                                        <td><p class="badge badge-secondary">{{ $item->padministrasi->nama }}</p></td>
-->

                                        {{-- Posisi --}}
                                        @if (durasi_posisi($item->updated_at, 5))
                                            <td class="text-center"><p class="badge badge-success p-1 posisi-coldown" data-time="{{ $item->updated_at }}">{{ $item->padministrasi->nama }}</p></td>
                                        @else
                                            <td class="text-center"><p class="badge badge-danger p-1 posisi-coldown" data-time="{{ $item->updated_at }}">{{ $item->padministrasi->nama }}</p></td>
                                        @endif

                                        {{-- proses --}}
                                        @if ($item->user)
                                            <td>
                                                {{ $item->user->namaPanjang }}
                                            </td>
                                        @else
                                            <td>Belum Ada</td>
                                        @endif
                                        @if ($item->user)
                                        <td>{{ isset($item->pdraf->nama) ? $item->pdraf->nama : '' }}</td>
                                        @endif

                                        <td>{{ $item->doc_rapat->keterangan }}</td>
                                        <td class="text-center">
                                            <a href="/rapat/{{ $item->judul }}" class="badge badge-info mb-2" style="cursor: pointer;"><i class="fas fa-edit"></i> Edit</a> <br>
                                            <a href="/pengajuan/destroy/{{ $item->judul }}" onclick="return confirm('Yakin ingin menghapus data ini?')" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection