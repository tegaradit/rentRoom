@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Data Peminjaman Saya</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Peminjaman</a></li>
                <li class="breadcrumb-item active">Peminjaman Saya</li>
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

            <table class="table datatable table-striped">
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
                                @if ($data->status == 'diterima')
                                    @php
                                        $currentTime = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
                                        $startTime = \Carbon\Carbon::parse($data->waktu_mulai)->format('H:i');
                                        $endTime = \Carbon\Carbon::parse($data->waktu_selesai)->format('H:i');
                                        $currentDate = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');
                                        $borrowingDate = \Carbon\Carbon::parse($data->tgl_peminjaman)->format('Y-m-d');
                                    @endphp
                                    @if ($borrowingDate >= $currentDate)
                                        @if ($currentTime < $startTime)
                                            belum mulai
                                        @elseif ($currentTime > $endTime)
                                            waktu habis
                                        @else
                                            @php
                                            $remainingTimeInMinutes = (strtotime($data->waktu_selesai) - strtotime($currentTime)) / 60;
                                            $days = floor($remainingTimeInMinutes / 1440);
                                            $hours = floor(($remainingTimeInMinutes % 1440) / 60);
                                            $minutes = $remainingTimeInMinutes % 60;
                                            $remainingTime = sprintf('%d hari, %02d jam, %02d menit', $days, $hours, $minutes);
                                            @endphp
                                            {{ $remainingTime }}
                                        @endif
                                    @else
                                        waktu habis
                                    @endif
                                @else
                                -
                                @php $canReturn = false @endphp
                                @endif
                            </td>                                                    
                            <td>{{ $data->keperluan }}</td>
                            <td>
                                @if ($data->status == 'pending')
                                    <span class="badge bg-warning">{{ $data->status }}</span>
                                @elseif ($data->status == 'diterima')
                                    <span class="badge bg-success">{{ $data->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $data->status }}</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tampilkan tombol "Kembalikan" hanya jika waktu masih tersisa --}}
                                @if ($data->status == 'diterima' && $canReturn)
                                    <a href="#" class="btn btn-sm btn-primary">Kembalikan</a>
                                @elseif ($data->status == 'pending')
                                    <button onclick="confirmDelete({{ $data->id }})" class="btn btn-sm btn-danger">Batalkan</button>
                                    <form id="delete-form-{{ $data->id }}" action="{{ route('peminjaman_saya.destroy', $data->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </td>   
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
                    confirmButtonText: 'Ya',
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
