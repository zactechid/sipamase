@extends('partviewAdmin.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6 mt-3">
                <h1 class="m-0">{{ $title }} Settings</h1>
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
                            <i class="fas fa-plus"></i> Tambah Pemegang Draft
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="dataTable table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pemegang Draft</th>
                                    <th class="col-md-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pdraf as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-info" style="cursor: pointer;" data-toggle="modal" data-target="#modal-edit{{ $item->id }}"><i class="fas fa-edit"></i> Edit</span>
                                            <a href="/pdraf/{{ $item->id }}" onclick="return confirm('Tunggu Fitur Selesai')" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pemegang Draft</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                @csrf
                    <div class="form-group">
                        <label for="PEMEGANGDRAFBaru">Pemegang Draft Baru</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="PEMEGANGDRAFBaru" name="nama" required autocomplete="off">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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

@foreach ($pdraf as $item)
<div class="modal fade" id="modal-edit{{ $item->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Pemegang Draft</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/pdraf/{{ $item->id }}" method="POST">
                @csrf
                    <div class="form-group">
                        <label for="editPEMEGANGDRAF">Edit Pemegang Draft</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="editPEMEGANGDRAF" name="nama" required maxlength="50" autocomplete="off" value="{{ $item->nama }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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