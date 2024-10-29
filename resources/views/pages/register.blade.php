@extends('layouts.root')

@section('root-content')
<div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                    <div class="d-flex justify-content-center py-4">
                        <a href="index.html" class="logo d-flex align-items-center w-auto">
                            <img src="assets/img/logo.png" alt="">
                            <span class="d-none d-lg-block">Rent Room Smenza</span>
                        </a>
                    </div><!-- End Logo -->
                    <div class="card mb-3">
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ol type="1">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ol>
                            </div>
                            @endif

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Buat Akun</h5>
                                <p class="text-center small">Masukan Data diri Pribadi kamu untuk mendaftar akun</p>
                            </div>
                            <form class="row g-3 needs-validation" novalidate method="post" action="{{ route('register.post') }}">
                                @csrf
                                <div class="col-12">
                                    <label for="yourName" class="form-label">Nama Lengkap Kamu</label>
                                    <input type="text" name="name" class="form-control" id="yourName" required>
                                    <div class="invalid-feedback">Nama Kamu Belum di Isi!</div>
                                </div>

                                <div class="col-12">
                                    <label for="yourNis" class="form-label">NIS</label>
                                    <input type="number" name="nis" class="form-control" id="yourNis" required>
                                    <div class="invalid-feedback">NIS Kamu Belum di Isi!</div>
                                </div>

                                <div class="col-12">
                                    <label for="yourPhone" class="form-label">No Telepon</label>
                                    <input type="number" name="noTelepon" class="form-control" id="yourPhone" required>
                                    <div class="invalid-feedback">Nomor telepon kamu belum di isi!</div>
                                </div>

                                <div class="col-12">
                                    <label for="yourJurusan" class="form-label">Jurusan</label>
                                    <select name="jurusan" id="yourJurusan" class="form-select" required>
                                        <option value="">Pilih Jurusan</option>
                                        <option value="X AKL 1">X AKL 1</option>
                                        <option value="X AKL 2">X AKL 2</option>
                                        <option value="X AKL 3">X AKL 3</option>
                                        <option value="X AKL 4">X AKL 4</option>
                                    </select>
                                    <div class="invalid-feedback">Jurusan Belum di Isi!</div>
                                </div>

                                <div class="col-12">
                                    <label for="yourEmail" class="form-label">Email Kamu</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                        <input type="email" name="email" class="form-control" id="yourEmail" required>
                                        <div class="invalid-feedback">Email Kamu belum di Isi!</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                                    <div class="invalid-feedback">Password Kamu belum di Isi!</div>
                                </div>

                                <div class="col-12">
                                    <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" required>
                                    <div class="invalid-feedback">Konfirmasi Password belum di Isi!</div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" name="terms" type="checkbox" id="acceptTerms" required>
                                        <label class="form-check-label" for="acceptTerms">Saya setuju dengan <a href="#">syarat dan ketentuan</a></label>
                                        <div class="invalid-feedback">Anda harus menyetujui sebelum mendaftar.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Buat Akun</button>
                                </div>
                                <div class="col-12">
                                    <p class="small mb-0">Sudah punya akun? <a href="/">Login</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>
@endsection