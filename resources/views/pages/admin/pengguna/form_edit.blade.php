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

@if ($errors->any())
<ul class="alert alert-danger" style="padding-left: 2rem;">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<section class="section data_user">
    <div class="col-lg-12"> 
        <form action="{{ route('pengguna.update', $data_pengguna->id) }}" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
            @csrf
            @method('PUT')

            <!-- Photo Upload Section -->
            <div class="col-12 text-center mb-4">
                <label for="photo" class="form-label">Photo</label>
                <div class="photo-preview-container">
                    <img id="photoPreview" src="{{ $data_pengguna->photo ? asset('storage/'.$data_pengguna->photo) : 'https://via.placeholder.com/150' }}" alt="Preview" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <input type="file" name="photo" id="photo" class="form-control mt-2" accept="image/*" onchange="previewPhoto(event)">
                <div class="invalid-feedback">Photo harus diupload!</div>
            </div>

            <!-- User Information Section -->
            <div class="col-6">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="name" class="form-control" value="{{ old('name', $data_pengguna->nama_lengkap) }}" required>
                    <div class="invalid-feedback">Nama lengkap harus diisi!</div>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" name="role" id="role" class="form-control" readonly value="{{ $data_pengguna->role_id == 1 ? 'admin' : ($data_pengguna->role_id == 3 ? 'guru' : 'siswa') }}">
                    <div class="invalid-feedback">Role harus dipilih!</div>
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

                @if ($data_pengguna->role_id != 2)
                    <div class="form-group">
                        <label for="noTelepon">No Telepon</label>
                        <input type="number" name="noTelepon" id="noTelepon" class="form-control" value="{{ old('noTelepon', $data_pengguna->no_hp) }}">
                        <div class="invalid-feedback">Nomor telepon harus diisi!</div>
                    </div>
                @endif

                @if ($data_pengguna->role_id == 3)
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

                    <div class="form-group" id="jurusanContainer" style="{{ $data_pengguna->nis != null ? '' : 'display: none;' }}">
                        <label for="jurusan">Jurusan</label>
                        <select name="jurusan" id="jurusan" class="form-select">
                            <option value="">Pilih Jurusan</option>
                            @foreach($data_jurusan as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ $data_pengguna->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                            @endforeach
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
    function previewPhoto(event) {
        const photoPreview = document.getElementById('photoPreview');
        photoPreview.src = URL.createObjectURL(event.target.files[0]);
        photoPreview.onload = () => URL.revokeObjectURL(photoPreview.src);
    }
</script>
@endsection
