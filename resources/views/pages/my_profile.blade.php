@extends('layouts.root-layout')


@section('content')
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
                @if (isset($dataProfile->photo))
                <img src="{{ Storage::url($dataProfile->photo) }}"
                    style="width: 8rem; height: 8rem; object-fit: cover;"
                    alt="Profile" class="rounded-circle">
                @else
                <div style="width: 8rem; height: 8rem; border-radius: 50%; background-color: gray; text-align: center; line-height: 8rem; font-size: 1.8rem; color: white">
                    {{ substr(Auth::user()->nama_lengkap, 0, 2) }}
                </div>
                @endif

                <h2>{{ $dataProfile->nama_lengkap }}</h2>
                <p>{{ $dataProfile->email }}</p>
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
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade profile-overview {{ $errors->any() ? '' : 'show active' }}" id="profile-overview">
                        <h5 class="card-title">Detail Profil</h5>

                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Nama Lengkap</div>
                            <div class="col-lg-9 col-md-8">{{ $dataProfile->nama_lengkap }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">NIS</div>
                            <div class="col-lg-9 col-md-8">{{ $dataProfile->nis ?? '-' }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Email</div>
                            <div class="col-lg-9 col-md-8">{{ $dataProfile->email }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">No. HP</div>
                            <div class="col-lg-9 col-md-8">{{ $dataProfile->no_hp }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Tipe Akun</div>
                            <div class="col-lg-9 col-md-8">{{ $dataProfile->role_id == 1 ? 'Admin' : 'Guru' }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Jurusan</div>
                            <div class="col-lg-9 col-md-8">{{ $dataProfile->jurusan->nama ?? '-' }}</div>
                        </div>

                    </div>

                    <!-- Edit Profile Section -->
                    <div class="tab-pane fade profile-edit pt-3 {{ $errors->any() ? 'show active' : '' }}" id="profile-edit">
                        <form action="{{ route('my_profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row mb-3">
                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                <div class="col-md-8 col-lg-9">
                                    <div id="trigger-input-img" style="cursor: pointer; width: 8rem; height: 8rem; background-color: gray; text-align: center; line-height: 8rem; color: white">
                                        <input hidden type="file" name="photo" id="input-img" accept=".png,.jpg,.jpeg,.webp">
                                        <input hidden type="text" value="false" name="request-del-profile" id="request-del-profile">
                                        <img id="img-preview" src="{{ Storage::url($dataProfile->photo) }}" style="width: 8rem; height: 8rem; object-fit: cover;" alt="Profile">
                                        <span id="fallback-text">upload photo</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nama_lengkap" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                <div class="col-md-8 col-lg-9">
                                    <input required name="nama_lengkap" type="text" class="form-control" id="nama_lengkap" value="{{ $dataProfile->nama_lengkap }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nis" class="col-md-4 col-lg-3 col-form-label">NIS</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="nis" type="text" class="form-control" id="nis" value="{{ $dataProfile->nis ?? '' }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                <div class="col-md-8 col-lg-9">
                                    <input required name="email" type="email" class="form-control" id="email" value="{{ $dataProfile->email }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="no_hp" class="col-md-4 col-lg-3 col-form-label">No. HP</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="no_hp" type="text" class="form-control" id="no_hp" value="{{ $dataProfile->no_hp }}">
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