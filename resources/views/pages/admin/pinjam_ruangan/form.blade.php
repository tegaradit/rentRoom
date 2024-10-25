@extends('layouts.page')

@section('page-content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

    <style>
        .grid-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            /* Make form card twice as wide as info card */
            gap: 16px;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transition: box-shadow 0.3s ease;
            position: relative;
            width: 100%;
        }

        .card-thumbnail {
            margin: 10px;
            /* Add margin to create space around the thumbnail */
        }

        .card-thumbnail img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ccc;
        }

        .card-body {
            padding: 16px;
        }

        .nama-ruangan {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 8px;
        }

        /* This will ensure status and kapasitas are on the same row */
        .card-info {
            display: flex;
            justify-content: space-between;
            /* Space between status and kapasitas */
            align-items: center;
            /* Ensure both are vertically centered */
            margin-bottom: 16px;
        }

        .status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-block;
        }

        .status.tersedia {
            background-color: rgba(0, 128, 0, 0.761);
            color: white;
        }

        .status.terpinjam {
            background-color: rgba(255, 0, 0, 0.768);
            color: white;
        }

        .kapasitas {
            padding: 4px 12px;
            border-radius: 20px;
            background-color: rgba(150, 156, 48, 0.422);
            font-size: 0.85rem;
            color: black;
            display: inline-block;
        }

        .deskripsi {
            font-size: 0.9rem;
            color: #333;
            text-align: left;
            margin: 12px 0;
        }

        .card-actions {
            position: absolute;
            bottom: 16px;
            right: 16px;
            display: flex;
            justify-content: flex-end;
        }
    </style>

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
        <div class="grid-container">
            <!-- Form Card - Takes up 2 grid columns (wider) -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" style="text-align: center">- {{ $ruangan->nama_ruangan }} -</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ruangan.peminjaman.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="ruangan_id" value="{{ $ruangan->id }}">
                        <div class="form-group mb-3">
                            <label for="tgl_peminjaman">Tanggal Peminjaman</label>
                            <input type="date" name="tgl_peminjaman" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="waktu_mulai">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="waktu_selesai">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="keperluan">Keperluan</label>
                            <textarea name="keperluan" class="form-control" rows="3" required></textarea>
                        </div>
                        <input type="hidden" name="status" value="pending">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title" style="text-align: center">- Informasi Ruangan -</h5>
                </div>
                <div class="card-thumbnail">
                    <img src="{{ asset('storage/' . $ruangan->thumbnail) }}" alt="Thumbnail Ruangan" class="img-fluid" />
                </div>
                <div class="card-body">
                    <h3 class="nama-ruangan">{{ $ruangan->nama_ruangan }}</h3>
                    <div class="card-info">
                        <span class="status {{ strtolower($ruangan->status) }}">
                            {{ ucfirst($ruangan->status) }}
                        </span>
                        <span class="kapasitas">{{ $ruangan->kapasitas }} orang</span>
                    </div>
                    <p class="deskripsi">{{ $ruangan->deskripsi }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
