@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1> Data Jurusan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item"><a href="{{ route('data_jurusan.index') }}">Data Jurusan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
    <section class="section data_jurusan">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" style="text-align: center">Form tambah jurusan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('data_jurusan.store') }}" method="post" class="row g-3 needs-validation"
                        novalidate>
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name">
                                Nama Jurusan
                            </label>
                            <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">
                                Ketua Jurusan
                            </label>
                            <input type="text" name="ketua_jurusan" id="ketua_jurusan" class="form-control" required>
                        </div>
                        <div class="form-group mb-3 mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
