@extends('layouts.root')

@section('root-content')
    <div class="pagetitle">
        <h1>Pinjam Ruangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Peminjaman</a></li>
                <li class="breadcrumb-item active">Pinjam Ruangan</li>
            </ol>
        </nav>
    </div>

    {{-- <form id="delete-form-{{ $data->id }}" action="{{ route('golongan_guru.destroy', $data->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form> 
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
        </script> --}}
@endsection
