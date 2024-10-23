@extends('layouts.root')

@section('root-content')
    <div class="pagetitle">
        <h1>Pangkat & Golongan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Pangkat & Golongan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section pangkat_golongan">
        <div class="col-lg-12">
            <a href="#" class="btn btn-primary">Tambah</a>

            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table datatable table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Golongan</th>
                        <th>Pangkat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @forelse ($datas as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->golongan }}</td>
                            <td>{{ $data->pangkat }}</td>
                            <td>
                                <a href="{{ route('golongan_guru.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                                <button class="btn btn-danger" onclick="confirmDelete('{{ $data->id }}')">Hapus</button>
                                <form id="delete-form-{{ $data->id }}" action="{{ route('golongan_guru.destroy', $data->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center alert alert-danger">Data Golongan & Pangkat masih
                                Kosong</td>
                        </tr>
                    @endforelse
                </tbody> --}}
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
