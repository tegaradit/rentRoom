@extends('layouts.page')

@section('page-content')
<div class="pagetitle">
    <h1>Tambah Data Pengguna</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengguna.index') }}">Data Pengguna</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<section class="section pengguna">
    <div class="col-lg-12">
        <form action="{{ route('pengguna.store') }}" method="post" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <div class="col-6">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                    <div class="invalid-feedback">Nama Kamu Belum di Isi!</div>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-select">
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                    </select>
                    <div class="invalid-feedback">Role Belum di Pilih!</div>
                </div>

                <div class="form-group" id="nisContainer">
                    <label for="nis">NIS</label>
                    <input type="number" name="nis" class="form-control">
                    <div class="invalid-feedback">NIS Kamu Belum di Isi!</div>
                </div>

                <div class="form-group" id="nipNikContainer" style="display: none;">
                    <label for="nip">NIP</label>
                    <input type="number" name="nip" class="form-control mb-2" placeholder="Masukkan NIP jika ada">
                    <label for="nik">NIK</label>
                    <input type="number" name="nik" class="form-control" placeholder="Masukkan NIK jika tidak memiliki NIP">
                    <div class="invalid-feedback">NIP atau NIK harus diisi!</div>
                </div>

                <div class="form-group" id="noTeleponContainer" style="display: none;">
                    <label for="noTelepon">No Telepon</label>
                    <input type="number" name="noTelepon" class="form-control">
                    <div class="invalid-feedback">Nomor telepon kamu belum di isi!</div>
                </div>

                <div class="form-group" id="jurusanContainer" style="display: none;">
                    <label for="jurusan">Jurusan</label>
                    <select name="jurusan" id="jurusan" class="form-select">
                        <option value="">Pilih Jurusan</option>
                        @foreach($data_jurusan as $jurusan)
                        <option value="{{ $jurusan->id }}">
                            {{ $jurusan->nama_jurusan }}
                        </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Jurusan harus dipilih untuk siswa!</div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
                    <div class="invalid-feedback">Email Kamu belum di Isi!</div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <div class="invalid-feedback">Password Kamu belum di Isi!</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                    <div class="invalid-feedback">Konfirmasi Password belum di Isi!</div>
                </div>

                <div class="form-group">
                    <label for="photo">Upload Foto</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div class="invalid-feedback">Foto belum diunggah!</div>
                </div>

                <div class="form-group">
                    <label for="photoPreview">Preview Foto</label>
                    <img id="photoPreview" src="" alt="Preview Foto" class="img-thumbnail mt-2" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover;">
                </div>

                <div class="form-check">
                    <input class="form-check-input" name="terms" type="checkbox" id="acceptTerms">
                    <label class="form-check-label" for="acceptTerms">Saya setuju dengan <a href="#">syarat dan ketentuan</a></label>
                    <div class="invalid-feedback">Anda harus menyetujui sebelum mendaftar.</div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    // Function to show the preview of the uploaded image
    function previewImage(event) {
        const photoPreview = document.getElementById('photoPreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.style.display = 'block'; // Show the preview
            }
            reader.readAsDataURL(file);
        } else {
            photoPreview.src = "";
            photoPreview.style.display = 'none'; // Hide preview if no file is selected
        }
    }

    document.getElementById('role').addEventListener('change', function() {
        const nisContainer = document.getElementById('nisContainer');
        const nipNikContainer = document.getElementById('nipNikContainer');
        const jurusanContainer = document.getElementById('jurusanContainer');
        const noTeleponContainer = document.getElementById('noTeleponContainer');

        // Reset visibility and required attributes
        nisContainer.style.display = 'none';
        nipNikContainer.style.display = 'none';
        jurusanContainer.style.display = 'none';
        noTeleponContainer.style.display = 'none';

        // Handle visibility and required attributes
        if (this.value === 'guru') {
            nipNikContainer.style.display = 'block';
            noTeleponContainer.style.display = 'block'; // Tampilkan No Telepon untuk Guru
        } else if (this.value === 'siswa') {
            nisContainer.style.display = 'block';
            jurusanContainer.style.display = 'block';
            noTeleponContainer.style.display = 'block'; // Tampilkan No Telepon untuk Siswa
        }
    });
</script>

@endsection
