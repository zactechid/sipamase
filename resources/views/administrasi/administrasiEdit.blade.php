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
                    <div class="card-body">
                        {{-- form --}}
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group col-md-4">
                                            <label for="tahun">Tahun</label>
                                            <input type="text" class="form-control @error('tahun') is-invalid @enderror" id="tahun" value="{{ app('selectedYear') }}" readonly>
                                            @error('tahun')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="pemrakarsa">PEMRAKARSA</label>
                                            <input type="text" class="form-control @error('tahun') is-invalid @enderror" id="tahun" value="{{ $getHarmonisasi->pemrakarsa->nama }}" readonly>
                                            @error('pemrakarsa')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group col-5">
                                            <label for="judul">Judul Rancangan</label>
                                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" placeholder="Judul" value="{{ $getHarmonisasi->judul }}" readonly>
                                            @error('judul')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="rancangan">Rancangan Harmonisasi</label>
                                            <input type="text" class="form-control" id="rancangan" value="{{ $rancangan }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group col-md-5">
                                            <label for="permohonan">Tanggal Permohonan</label>
                                            <input type="date" class="form-control @error('permohonan') is-invalid @enderror" id="permohonan" value="{{ $getHarmonisasi->tanggal }}" readonly>
                                            @error('permohonan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="status">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                            <option value="{{ $getHarmonisasi->status_administrasi }}" selected>{{ $getHarmonisasi->status_administrasi }}</option>
                                            @foreach ($status as $item)
                                                @if ($item == $getHarmonisasi->status_administrasi || $item == $getHarmonisasi->status_administrasi)
                                                    <option value="" style="display: none;"></option>
                                                @else
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                             
                            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group col-md-5">
                                            <label for="pdraf">Pemegang Draft</label>
                                            <select class="form-control @error('pdraf') is-invalid @enderror" id="pdraf" name="pdraf">
                                                @foreach ($pdraf as $item)
                                                    @if($item->id == $getHarmonisasi->pdraf_id)
                                                    <option selected value="{{ $item->id }}">{{ $item->nama }}</option>
                                                    @else
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('pdraf')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row mt-3 ml-1">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Enter ..." name="keterangan">{{ $getHarmonisasi->doc_administrasi->keterangan }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @include('administrasi.docEditAdministrasi')

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success inline">Simpan Data</button>
                                <a href="/administrasi" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection