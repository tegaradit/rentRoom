@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Ruangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item active">Data Ruangan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section ruangan">
        <div class="col-lg-12">
            <a href="{{ route('ruangan.create') }}" class="btn btn-primary">Tambah </a>

            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table datatable table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Thumbnail</th>
                        <th>Nama</th>
                        <th>Kapasitas</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><img src="{{ Storage::url($data->thumbnail) }}" style="width: 200px"></td>
                            <td>{{ $data->nama_ruangan }}</td>
                            <td>{{ $data->kapasitas }} orang</td>
                            <td>{{ $data->deskripsi }}</td>
                            <td>
                                @if ($data->status === 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @elseif ($data->status === 'terpinjam')
                                    <span class="badge bg-warning">Terpinjam</span>
                                @else
                                    <span class="badge bg-secondary">Tidak diketahui</span>
                                    <!-- opsi tambahan jika status tidak sesuai -->
                                @endif
                                </td>
                                <td>
                                    <a href="{{ route('ruangan.edit', $data->id) }}" class="btn btn-warning btn-sm edit ms-1">
                                    <i data-feather="edit"></i></a>
                                    <button class="btn btn-danger btn-sm delete ms-1"
                                        onclick="confirmDelete('{{ $data->id }}')"><i data-feather="trash-2"></i></button>
                                    <form id="delete-form-{{ $data->id }}"
                                        action="{{ route('ruangan.destroy', $data->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center alert alert-danger">Data Ruangan masih Kosong</td>
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
