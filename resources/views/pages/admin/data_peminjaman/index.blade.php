@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Data Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Data Peminjaman</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="col-lg-8 w-100 mb-3">
            <div class="row">
                {{-- Total Peminjaman --}}
                <div class="col-xxl-3 col-md-6 mb-3" style="height: fit-content !important; min-height: 0 !important;">
                    <div class="card info-card h-100 sales-card px-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Peminjaman</h5>
                            <div class="d-flex align-items-center">
                                <div style="background-color: rgba(63, 15, 235, 0.116);"
                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar2-week-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalPeminjaman }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Disetujui --}}
                <div class="col-xxl-3 col-md-6 mb-3" style="height: fit-content !important; min-height: 0 !important;">
                    <div class="card info-card h-100 revenue-card px-3">
                        <div class="card-body">
                            <h5 class="card-title">Disetujui</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar2-check-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $disetujui }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ditolak --}}
                <div class="col-xxl-3 col-md-6 mb-3" style="height: fit-content !important; min-height: 0 !important;">
                    <div class="card info-card h-100 customers-card px-3">
                        <div class="card-body">
                            <h5 class="card-title">Ditolak</h5>
                            <div class="d-flex align-items-center">
                                <div style="background-color: rgba(255,0,0,.1);"
                                    class="text-danger card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar2-x-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $ditolak }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Dibatalkan --}}
                <div class="col-xxl-3 col-md-6 mb-3" style="height: fit-content !important; min-height: 0 !important;">
                    <div class="card info-card h-100 customers-card px-3">
                        <div class="card-body">
                            <h5 class="card-title">Dibatalkan</h5>
                            <div class="d-flex align-items-center">
                                <div style="background-color: rgba(255,0,0,.1);"
                                    class="text-danger card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar2-minus-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $dibatalkan }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table datatable table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal peminjaman</th>
                        <th>Waktu mulai</th>
                        <th>Waktu selesai</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->user->nama_lengkap }}</td>
                            <td>{{ $data->ruangan->nama_ruangan }}</td>
                            <td>{{ $data->tgl_peminjaman }}</td>
                            <td>{{ $data->waktu_mulai }}</td>
                            <td>{{ $data->waktu_selesai }}</td>
                            <td>{{ $data->keperluan }}</td>
                            <td>
                                @if ($data->status == 'pending')
                                    <span class="badge bg-warning">{{ $data->status }}</span>
                                @elseif ($data->status == 'disetujui')
                                    <span class="badge bg-success">{{ $data->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $data->status }}</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('peminjaman.setuju', $data->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Setuju</button>
                                </form>
                                <form action="{{ route('peminjaman.tolak', $data->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Tidak Setuju</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center alert alert-danger">Data Peminjaman masih
                                Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    </section>
@endsection
