@extends('layouts.page')

@section('page-content')
<div class="pagetitle">
	<h1>Edit Data Jurusan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('data_jurusan.index') }}">Jenis Diklat</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

	<section class="section data_jurusan">
		<div class="col-lg-12">
				{{-- <a href="{{route('data_jurusan.create')}}" class="btn btn-primary">Tambah</a> --}}
        <form action="{{route('data_jurusan.update', $data_jurusan->id)}}" method="post" class="row g-3 needs-validation"
                    novalidate>
                    @csrf
                    @method('PUT')
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">
                                Nama Jurusan
                            </label>
                            <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control" value="{{$data_jurusan->nama_jurusan}}" required>
                            <div class="invalid-feedback">Please, enter your name!</div>
                        </div>
                        <div class="form-group">
                            <label for="name">
                                Ketua Jurusan
                            </label>
                            <input type="text" name="ketua_jurusan" id="ketua_jurusan" class="form-control" value="{{$data_jurusan->ketua_jurusan}}" required>
                            <div class="invalid-feedback">Please, enter your name!</div>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
	        </form>
	    </div>
    </section>
@endsection