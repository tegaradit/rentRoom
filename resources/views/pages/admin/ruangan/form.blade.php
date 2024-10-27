@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Ruangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item"><a href="{{ route('ruangan.index') }}">Data Ruangan</a></li>
                <li class="breadcrumb-item active">{{ isset($ruangan) ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section ruangan">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" style="text-align: center">Form tambah ruangan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($ruangan) ? route('ruangan.update', $ruangan->id) : route('ruangan.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        @if (isset($ruangan))
                            @method('PUT')
                        @endif
                        <div class="form-group mb-3">
                            <label for="nama_ruangan">Nama Ruangan</label>
                            <input type="text" name="nama_ruangan" id="nama_ruangan" class="form-control"
                                value="{{ old('nama_ruangan', isset($ruangan) ? $ruangan->nama_ruangan : '') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kapasitas">Kapasitas</label>
                            <input type="number" name="kapasitas" id="kapasitas" class="form-control"
                                value="{{ old('kapasitas', isset($ruangan) ? $ruangan->kapasitas : '') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control">{{ old('deskripsi', isset($ruangan) ? $ruangan->deskripsi : '') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="thumbnail">Thumbnail (Foto)</label>
                            <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                            @if (isset($ruangan) && $ruangan->thumbnail)
                                <img src="{{ asset('storage/' . $ruangan->thumbnail) }}" alt="Thumbnail"
                                    style="max-width: 200px; margin-top: 10px;">
                            @endif
                        </div>

                        <div class="form-group mb-3 mt-4">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($ruangan) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
