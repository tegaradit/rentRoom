@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Ruangan Pinjam</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Ruangan Pinjam</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section ruangan">
        <div class="col-lg-12">
            <div class="grid-container">
                @foreach ($datas as $ruangan)
                    <div class="card">
                        <div class="card-thumbnail">
                            <img src="{{ asset('storage/' . $ruangan->thumbnail) }}" alt="Thumbnail Ruangan"
                                class="img-fluid" />
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
                            <div class="card-actions mt-3">
                                @if (strtolower($ruangan->status) == 'terpinjam')
                                    <a href="#" class="btn btn-secondary">Sedang Dipinjam</a>
                                @else
                                    <a href="#" class="btn btn-primary">Pinjam</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $datas->links() }}
        </div>
    </section>

    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 16px;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transition: box-shadow 0.3s ease;
            text-align: center;
            position: relative;
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
            padding-bottom: 50px;
        }

        .card-actions {
            position: absolute;
            bottom: 16px;
            right: 16px;
            display: flex;
            justify-content: flex-end;
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
