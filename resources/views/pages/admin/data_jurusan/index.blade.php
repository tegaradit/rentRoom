@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Data Jurusan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item active"> Data Jurusan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        {{-- card --}}
        <div class="col-lg-8 w-100 mb-3">
            <div class="row">
                {{-- Jurusan --}}
                <div class="col-xxl-12 col-md-6" style="height: fit-content !important; min-height: 0 !important;">
                    <div class="card info-card h-100 sales-card px-3">
                        <div class="card-body">
                            <h5 class="card-title">Total jurusan</h5>
                            <div class="d-flex align-items-center">
                                <div style="background-color: rgba(63, 15, 235, 0.116);" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalJurusan }}</h6> <!-- jurusan dari database -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end card --}}
        <div class="col-lg-12">
            <a href="{{ route('data_jurusan.create') }}" class="btn btn-sm btn-primary">Tambah</a>
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table datatable table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jurusan</th>
                        <th>Ketua Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->nama_jurusan }}</td>
                            <td>{{ $data->ketua_jurusan }}</td>
                            <td>
                                <a href="{{ route('data_jurusan.edit', $data->id) }}" class="btn btn-warning btn-sm edit ms-1">
                                    <i data-feather="edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm delete ms-1" onclick="confirmDelete('{{ $data->id }}')">
                                    <i data-feather="trash-2"></i>
                                </button>
                                <form id="delete-form-{{ $data->id }}"
                                    action="{{ route('data_jurusan.destroy', $data->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center alert alert-danger">Data jurusan masih
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
