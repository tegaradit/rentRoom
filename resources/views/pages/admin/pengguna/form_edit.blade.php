@extends('layouts.page')

@section('page-content')
<div class="pagetitle">
	<h1>Edit Data Pengguna</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengguna.index') }}">Data Pengguna</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section data_user">
    <div class="col-lg-12">
        <form action="{{ route('pengguna.update', $data_pengguna->id) }}" method="post" class="row g-3 needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="col-6">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $data_pengguna->nama_lengkap) }}" required>
                    <div class="invalid-feedback">Nama lengkap harus diisi!</div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $data_pengguna->email) }}" required>
                    <div class="invalid-feedback">Email harus diisi!</div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                </div>

                @if ($data_pengguna->role_id != 1)
                    <div id="nisContainer" style="{{ $data_pengguna->nis != null ? '' : 'display: none;' }}">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="number" name="nis" id="nis" class="form-control" value="{{ old('nis', $data_pengguna->nis) }}" {{ $data_pengguna->nis != null ? 'required' : '' }}>
                        <div class="invalid-feedback">NIS harus diisi untuk siswa!</div>
                    </div>

                    <div id="nipNikContainer" style="{{ $data_pengguna->nis == null ? '' : 'display: none;' }}">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="number" name="nip" id="nip" class="form-control mb-2" placeholder="Masukkan NIP jika ada" value="{{ old('nip', $data_pengguna->nip) }}">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="number" name="nik" id="nik" class="form-control" placeholder="Masukkan NIK jika tidak memiliki NIP" value="{{ old('nik', $data_pengguna->nik) }}">
                        <div class="invalid-feedback">NIP atau NIK harus diisi untuk guru!</div>
                    </div>

                    <div class="form-group">
                        <label for="noTelepon">No Telepon</label>
                        <input type="number" name="noTelepon" id="noTelepon" class="form-control" value="{{ old('noTelepon', $data_pengguna->no_hp) }}" required>
                        <div class="invalid-feedback">Nomor telepon harus diisi!</div>
                    </div>

                    <div class="form-group" id="jurusanContainer" style="{{ $data_pengguna->nis != null ? '' : 'display: none;' }}">
                        <label for="jurusan">Jurusan</label>
                        <select name="jurusan" id="jurusan" class="form-select">
                            <option value="">Pilih Jurusan</option>
                            <option value="X AKL 1" {{ $data_pengguna->jurusan_id == 1 ? 'selected' : '' }}>X AKL 1</option>
                            <option value="X AKL 2" {{ $data_pengguna->jurusan_id == 2 ? 'selected' : '' }}>X AKL 2</option>
                            <option value="X AKL 3" {{ $data_pengguna->jurusan_id == 3 ? 'selected' : '' }}>X AKL 3</option>
                            <option value="X AKL 4" {{ $data_pengguna->jurusan_id == 4 ? 'selected' : '' }}>X AKL 4</option>
                        </select>
                        <div class="invalid-feedback">Jurusan harus dipilih untuk siswa!</div>
                    </div>
                @endif

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    document.getElementById('role').addEventListener('change', function() {
        const nisContainer = document.getElementById('nisContainer');
        const nipNikContainer = document.getElementById('nipNikContainer');
        const jurusanContainer = document.getElementById('jurusanContainer');
        const nisInput = document.getElementById('nis');
        const nipInput = document.getElementById('nip');
        const nikInput = document.getElementById('nik');

        if (this.value === 'guru') {
            nisContainer.style.display = 'none';
            nipNikContainer.style.display = 'block';
            jurusanContainer.style.display = 'none';
            nisInput.required = false;
            nipInput.required = true;
            nikInput.required = true;
        } else {
            nisContainer.style.display = 'block';
            nipNikContainer.style.display = 'none';
            jurusanContainer.style.display = 'block';
            nisInput.required = true;
            nipInput.required = false;
            nikInput.required = false;
        }
    });
</script>
@endsection
    