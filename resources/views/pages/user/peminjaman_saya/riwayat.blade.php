@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Riwayat Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Peminjaman</a></li>
                <li class="breadcrumb-item active">Data Peminjaman</li>
                <li class="breadcrumb-item active">Riwayat Peminjaman</li>
            </ol>
        </nav>
    </div>

    <section class="section riwayat-peminjaman">
        <div class="timeline">
            @foreach ($riwayat as $item)
                <div class="timeline-item {{ $item->status == 'diterima' ? 'bg-accepted' : 'bg-rejected' }}">
                    <div class="timeline-status">
                        <span class="status-label {{ $item->status == 'diterima' ? 'approved' : 'rejected' }}">
                            {{ $item->status == 'diterima' ? 'Peminjaman Diterima' : 'Peminjaman Ditolak' }}
                        </span>
                        <span class="timeline-date">{{ \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d') }}</span>
                    </div>
                    <div class="timeline-content">
                        <p>Telah meminjam ruangan {{ $item->ruangan->nama_ruangan }} pada tanggal {{ $item->tgl_peminjaman }} dari jam {{ $item->waktu_mulai }} -
                            {{ $item->waktu_selesai }}</p>
                        <div class="ruangan-info">
                            <img src="{{ asset('storage/' . $item->ruangan->thumbnail) }}" alt="Thumbnail Ruangan"
                                class="ruangan-thumbnail" />
                            <div class="ruangan-details">
                                <h3>{{ $item->ruangan->nama_ruangan }}</h3>
                                <span class="kapasitas">Kapasitas: {{ $item->ruangan->kapasitas }} Orang</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <style>
        .timeline {
            padding: 20px;
            border-left: 2px solid #ddd;
            position: relative;
        }

        .timeline-item {
            position: relative;
            padding: 10px 20px;
            margin-left: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .timeline-status {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-label {
            font-size: 1rem;
            font-weight: bold;
            color: #444;
        }

        .approved {
            color: green;
        }

        .rejected {
            color: red;
        }

        .timeline-date {
            font-size: 0.9rem;
            color: #888;
        }

        .timeline-content {
            margin-top: 10px;
        }

        .ruangan-info {
            display: flex;
            align-items: center;
        }

        .ruangan-thumbnail {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            margin-right: 15px;
            object-fit: cover;
        }

        .ruangan-details h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .kapasitas {
            font-size: 0.9rem;
            color: #777;
        }

        .bg-accepted {
            background-color: rgba(144, 238, 144, 0.2);
        }

        .bg-rejected {
            background-color: rgba(255, 99, 71, 0.2);
        }
    </style>
@endsection
