@extends('layouts.page')

@section('page-content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach    
    @endif

    <div class="pagetitle">
        <h1>Ruangan Pinjam</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pinjam-ruangan.index') }}">Ruangan Pinjam</a></li>
                <li class="breadcrumb-item active">Buat Pinjam Ruangan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section peminjaman">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Isi Detail Peminjaman</h5>

                    <!-- Form Peminjaman -->
                    <form action="{{ route('ruangan.peminjaman.store') }}" method="POST">
                        @csrf
                        <!-- User ID (auto-filled from the logged-in user) -->
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <!-- Ruangan (auto-filled based on the ruangan selected) -->
                        <input type="hidden" name="ruangan_id" value="{{ $ruangan->id }}">

                        <!-- Tanggal Peminjaman -->
                        <div class="form-group mb-3">
                            <label for="tgl_peminjaman">Tanggal Peminjaman</label>
                            <input type="date" name="tgl_peminjaman" class="form-control" required>
                        </div>

                        <!-- Waktu Mulai -->
                        <div class="form-group mb-3">
                            <label for="waktu_mulai">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control" required>
                        </div>

                        <!-- Waktu Selesai -->
                        <div class="form-group mb-3">
                            <label for="waktu_selesai">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control" required>
                        </div>

                        <!-- Keperluan -->
                        <div class="form-group mb-3">
                            <label for="keperluan">Keperluan</label>
                            <textarea name="keperluan" class="form-control" rows="3" required></textarea>
                        </div>

                        <!-- Status (auto-filled as 'pending') -->
                        <input type="hidden" name="status" value="pending">

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                        </div>
                    </form><!-- End Form -->
                </div>
            </div>
        </div>
    </section>
@endsection
