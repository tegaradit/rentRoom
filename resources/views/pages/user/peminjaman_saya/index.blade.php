@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Data Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Peminjaman</a></li>
                <li class="breadcrumb-item active"> Data Peminjaman</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section data_peminjaman">
        <div class="col-lg-12">
            <a href="{{ route('pages.user.peminjaman_saya.riwayat') }}" class="btn btn-sm btn-primary">Riwayat</a>
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table datatable table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Ruangan</th>
                        <th>Tanggal peminjaman</th>
                        <th>Waktu mulai</th>
                        <th>Waktu selesai</th>
                        <th>Sisa waktu</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->ruangan->nama_ruangan ?? 'Ruangan tidak tersedia' }}</td>
                            <td>{{ $data->tgl_peminjaman }}</td>
                            <td>{{ $data->waktu_mulai }}</td>
                            <td>{{ $data->waktu_selesai }}</td>
                            <td>
                                {{ $data->status === 'pending' ? '-' : 'calculated remaining time' }}
                                <!-- Replace 'calculated remaining time' with the actual calculation if available -->
                            </td>
                            <td>{{ $data->keperluan }}</td>
                            <td>{{ $data->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">Tidak ada data peminjaman.</td>
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
