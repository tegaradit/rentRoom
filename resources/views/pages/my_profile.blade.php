@extends('layouts.page')

@section('page-content')
<div class="pagetitle">
    <h1>Profil Saya</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Profile Saya</li>
        </ol>
    </nav>
</div>

@if ($errors->any())
<ul class="alert alert-danger" style="padding-left: 2rem;">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif
<div class="row">
    @if (Session('message'))
        <div class="alert alert-success">{{ Session('message') }}</div>
    @endif
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                @if (isset($user->photo))
                <img src="{{ Auth::user()->photo ? asset('storage/'. Auth::user()->photo) : 'https://via.placeholder.com/150' }}" style="width: 8rem; height: 8rem; object-fit: cover;" alt="Profile" class="rounded-circle">
                @else
                <div style="width: 8rem; height: 8rem; border-radius: 50%; background-color: gray; text-align: center; line-height: 8rem; font-size: 1.8rem; color: white">
                    {{ substr(Auth::user()->nama_lengkap, 0, 2) }}
                </div>
                @endif
                <h2>{{ $user->nama_lengkap }}</h2>
                <p>{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">
            <div class="card-body pt-3">
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit</button>
                    </li>
                </ul>

                <div class="tab-content pt-2">
                    <!-- Overview Section -->
                    <div class="tab-pane fade profile-overview show active" id="profile-overview">
                        <h5 class="card-title">Detail Profil</h5>
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Nama Lengkap</div>
                            <div class="col-lg-9 col-md-8">{{ $user->nama_lengkap }}</div>
                        </div>
                        @if ($user->role_id == 3) <!-- //! only sbow the user role is "Guru"   -->
                            <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">NIK</div>
                                <div class="col-lg-9 col-md-8">{{ $user->nik }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">NIP</div>
                                <div class="col-lg-9 col-md-8">{{ $user->nip }}</div>
                            </div>
                        @endif
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">No. HP</div>
                            <div class="col-lg-9 col-md-8">{{ $user->no_hp }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Email</div>
                            <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                        </div>
                    </div>

                    <!-- Combined Edit Section -->
                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            
                            <!-- Profile Info Fields -->
                            <h5 class="card-title">Edit Informasi Profil</h5>
                            <div class="row mb-3">
                                <label for="nama_lengkap" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" value="{{ $user->nama_lengkap }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>
                                </div>
                            </div>
                            @if ($user->role_id == 3) <!-- //! only sbow the user role is "Guru"   -->
                                <div class="row mb-3">
                                    <label for="nip" class="col-md-4 col-lg-3 col-form-label">NIK</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="text" name="nik" class="form-control" id="nik" value="{{ $user->nik }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="nip" class="col-md-4 col-lg-3 col-form-label">NIP</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="text" name="nip" class="form-control" id="nip" value="{{ $user->nip }}">
                                    </div>
                                </div>
                            @endif
                            <div class="row mb-3">
                                <label for="no_hp" class="col-md-4 col-lg-3 col-form-label">No. HP</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="text" name="no_hp" class="form-control" id="no_hp" value="{{ $user->no_hp }}">
                                </div>
                            </div>

                            <!-- Password Change Fields -->
                            <h5 class="card-title mt-4">Edit Sandi</h5>
                            <div class="row mb-3">
                                <label for="current_password" class="col-md-4 col-lg-3 col-form-label">Sandi Saat Ini</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="password" name="current_password" class="form-control" id="current_password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="new_password" class="col-md-4 col-lg-3 col-form-label">Sandi Baru</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="password" name="new_password" class="form-control" id="new_password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="new_password_confirmation" class="col-md-4 col-lg-3 col-form-label">Konfirmasi Sandi Baru</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
