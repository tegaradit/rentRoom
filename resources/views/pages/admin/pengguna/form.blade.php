@extends('layouts.page')

@section('page-content')
<div class="pagetitle">
    <h1>Tambah Data Pengguna</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('data_jurusan.index') }}">Data Pengguna</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<section class="section data_jurusan">
    <div class="col-lg-12">
        <form action="{{ route('pengguna.store') }}" method="post" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="col-6">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required>
                    <div class="invalid-feedback">Nama Kamu Belum di Isi!</div>
                </div>
                
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">Pilih Role</option>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                    </select>
                    <div class="invalid-feedback">Role Belum di Pilih!</div>
                </div>

                <div class="form-group" id="nisContainer">
                    <label for="nis">NIS</label>
                    <input type="number" name="nis" class="form-control" required>
                    <div class="invalid-feedback">NIS Kamu Belum di Isi!</div>
                </div>

                <div class="form-group" id="nipNikContainer" style="display: none;">
                    <label for="nip">NIP</label>
                    <input type="number" name="nip" class="form-control mb-2" placeholder="Masukkan NIP jika ada">
                    <label for="nik">NIK</label>
                    <input type="number" name="nik" class="form-control" placeholder="Masukkan NIK jika tidak memiliki NIP">
                    <div class="invalid-feedback">NIP atau NIK harus diisi!</div>
                </div>

                <div class="form-group">
                    <label for="noTelepon">No Telepon</label>
                    <input type="number" name="noTelepon" class="form-control" required>
                    <div class="invalid-feedback">Nomor telepon kamu belum di isi!</div>
                </div>

                <div class="form-group" id="jurusanContainer">
                    <label for="jurusan">Jurusan</label>
                    <select name="jurusan" class="form-select">
                        <option value="">Pilih Jurusan</option>
                        <option value="X AKL 1">X AKL 1</option>
                        <option value="X AKL 2">X AKL 2</option>
                        <option value="X AKL 3">X AKL 3</option>
                        <option value="X AKL 4">X AKL 4</option>
                    </select>
                    <div class="invalid-feedback">Jurusan Belum di Isi!</div>
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
                    <input type="password" name="password_confirmation" class="form-control" required>
                    <div class="invalid-feedback">Konfirmasi Password belum di Isi!</div>
                </div>

                <div class="form-check">
                    <input class="form-check-input" name="terms" type="checkbox" id="acceptTerms" required>
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
    document.getElementById('role').addEventListener('change', function() {
        const nisContainer = document.getElementById('nisContainer');
        const nipNikContainer = document.getElementById('nipNikContainer');
        const jurusanContainer = document.getElementById('jurusanContainer');
        const nisInput = document.querySelector('input[name="nis"]');
        const nipInput = document.querySelector('input[name="nip"]');
        const nikInput = document.querySelector('input[name="nik"]');

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

    document.getElementById('nip').addEventListener('input', function() {
        const nikInput = document.getElementById('nik');
        nikInput.required = !this.value;
    });

    document.getElementById('nik').addEventListener('input', function() {
        const nipInput = document.getElementById('nip');
        nipInput.required = !this.value;
    });
</script>

@endsection
