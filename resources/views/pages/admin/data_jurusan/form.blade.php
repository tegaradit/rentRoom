@extends('layouts.page')

@section('page-content')
<div class="pagetitle">
    <h1>Tambah Data Jurusan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('data_jurusan.index') }}">Data Jurusan</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>
<section class="section data_jurusan">
    <div class="col-lg-12">
        <form action="{{route('data_jurusan.store')}}" method="post" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="col-6">
                <div class="form-group">
                    <label for="name">
                        Nama Jurusan
                    </label>
                    <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control" required>
                    <div class="invalid-feedback">Please, enter your name</div>
                </div>
                <div class="form-group">
                    <label for="name">
                        Ketua Jurusan
                    </label>
                    <input type="text" name="ketua_jurusan" id="ketua_jurusan" class="form-control" required>
                    <div class="invalid-feedback">Please, enter your name</div>
                </div>
                
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection