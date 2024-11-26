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
                    <div class="card-header text-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus"></i> Tambah Foto
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="dataTable table table-bordered table-responsive-md">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Foto</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($foto as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->judul_foto }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->lokasi }}</td>
                                        @if ($item->foto)
                                            <td><a href="{{ asset('storage') }}/{{ $item->foto }}" target="_blank">
                                               <!-- <img src="{{ asset('storage/'. $item->foto) }}" class="img-thumbnail" style="max-height: 120px"> -->
                                               <p class="badge badge-success"><i class="far fa-times-circle"></i> Lihat Gambar</p>
                                            </a></td>
                                        @else
                                            <td><p class="badge badge-danger"><i class="far fa-times-circle"></i> Tidak Ada Gambar</p></td>
                                        @endif
                                        <td class="text-center">
                                            
                                            <span class="badge badge-info" style="cursor: pointer;" data-toggle="modal" data-target="#modal-edit-{{ $item->id_foto }}"><i class="fas fa-edit"></i> Edit</span>
                                            <a href="/remove_foto/{{ $item->id_foto }}" onclick="return confirm('Yakin Ingin menghapus Data')" class="badge badge-danger mt-2"><i class="fas fa-trash"></i> Hapus</a>
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

{{-- tambah Data --}}
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Foto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('upload-foto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="form-group mt-3">
                        <label for="lokasi">Judul Foto</label>
                        <input type="text" class="form-control @error('judul_foto') is-invalid @enderror" id="judul_foto" name="judul_foto" required maxlength="100" autocomplete="off">
                        @error('judul_foto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> <div class="form-group mt-3">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" required>
                        @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" required maxlength="100" autocomplete="off">
                        @error('lokasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mt-4">
                        <h5>Upload Foto Kegiatan</h5>
                        <div class="col mb-5">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" id="foto" name="foto">
                                <label class="custom-file-label" for="upload">Choose file</label>
                                <small>Type : jpg, jpeg, png | Max : 5MB</small>
                                @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- tambah Data --}}
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Foto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('uploadfoto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="form-group mt-3">
                        <label for="lokasi">Judul Foto</label>
                        <input type="text" class="form-control @error('judul_foto') is-invalid @enderror" id="judul_foto" name="judul_foto" required maxlength="100" autocomplete="off">
                        @error('judul_foto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> <div class="form-group mt-3">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" required>
                        @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" required maxlength="100" autocomplete="off">
                        @error('lokasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mt-4">
                        <h5>Upload Foto Kegiatan</h5>
                        <div class="col mb-5">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" id="foto" name="foto">
                                <label class="custom-file-label" for="upload">Choose file</label>
                                <small>Type : jpg, jpeg, png | Max : 5MB</small>
                                @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($foto as $item)
<div class="modal fade" id="modal-edit-{{$item->id_foto}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Foto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('uploadfoto/'. $item->id_foto) }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="form-group mt-3">
                        <label for="lokasi">Judul Foto</label>
                        <input type="text" class="form-control @error('judul_foto') is-invalid @enderror" id="judul_foto" name="judul_foto" required maxlength="100" autocomplete="off" value="{{ $item->judul_foto }}">
                        @error('judul_foto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> <div class="form-group mt-3">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" required value="{{ $item->tanggal }}">
                        @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" required maxlength="100" autocomplete="off" value="{{ $item->lokasi }}">
                        @error('lokasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group mt-4">
                        <h5>Upload Foto Kegiatan</h5>
                        <div class="col mb-5">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" id="foto" name="foto">
                                <label class="custom-file-label" for="upload">Choose file</label>
                                <small>Type : jpg, jpeg, png | Max : 5MB</small>
                                @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                         <h5>Lihat & Hapus Foto Kegiatan</h5>
                        <div class="col">
                            <div class="custom-file">
                                @if ($item->foto == null)
                                    <div class="form-group col">
                                        <label class="badge badge-danger">Belum Ada Foto</label>
                                    </div>
                                @endif
                                @if ($item->foto)
                                    <div class="form-group col">
                                        <a target="_blank" class="badge badge-success mr-3" href="{{ asset('storage') }}/{{ $item->foto }}" style="cursor: pointer;"><i class="fas fa-download"></i> Lihat Foto</a>
                                        <a class="badge badge-danger mt-2" onclick="return confirm('Yakin ingin hapus Foto?')" href="/remove_foto/{{ $item->id_foto }}" style="cursor: pointer;"><i class="fas fa-trash"></i> Hapus Foto</a>
                                        <input type="text" value="{{ $item->foto }}" class="d-none" name="oldImage">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection