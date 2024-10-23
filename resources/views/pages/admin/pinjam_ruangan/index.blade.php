@extends('layouts.root')

@section('root-content')
    <div class="pagetitle">
        <h1>Ruangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Ruangan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section ruangan">
        <div class="col-lg-12">

            <div class="row">
                @foreach ($datas as $ruangan)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-thumbnail">
                                <img src="{{ asset('storage/' . $ruangan->thumbnail) }}" alt="Thumbnail Ruangan"
                                    class="img-fluid" />
                            </div>

                            <div class="card-body">
                                <h3 class="nama-ruangan">{{ $ruangan->nama_ruangan }}</h3>
                                <div class="card-info">
                                    <span class="status {{ $ruangan->status }}">{{ ucfirst($ruangan->status) }}</span>
                                    <span class="kapasitas">Kapasitas: {{ $ruangan->kapasitas }} orang</span>
                                </div>
                                <p class="deskripsi">{{ $ruangan->deskripsi }}</p> <!-- Menambahkan deskripsi di sini -->
                                <div class="card-actions mt-3">
                                    <a href="#" class="btn btn-primary">Pinjam</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $datas->links() }}
        </div>
    </section>

    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card-thumbnail img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 16px;
        }

        .nama-ruangan {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .card-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 16px;
        }

        .status {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .kapasitas {
            padding: 2px 8px;
            border-radius: 12px;
            background-color: rgba(176, 202, 48, 0.3);
            align-content: space-between;
        }

        .deskripsi {
            font-size: 0.9rem;
            color: #333;
            text-align: left;
            margin: 12px 0;
            /* Memberikan jarak antara deskripsi dan tombol */
        }

        .card-actions {
            display: flex;
            justify-content: space-between;
        }

        .card-actions .btn {
            padding: 8px 16px;
            font-size: 0.9rem;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
@endsection
