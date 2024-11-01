@extends('layouts.root')

@section('root-content')
<header id="header" class="header fixed-top d-flex align-items-center">

   <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
         <img src="/assets/themes/nice/assets/img/logo.png" alt="">
         <span class="d-none d-lg-block">RentRooms</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
   </div><!-- End Logo -->

   <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
         <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
               <div>
                  <img style="border-radius: 50%; width: 2.5rem; height: 2.5rem;aspect-ratio: 1/1; object-fit: cover; background-color: black; text-align: center; line-height: 2.5rem; color: white" src="{{ Auth::user()->photo ? asset('storage/'. Auth::user()->photo) : 'https://via.placeholder.com/150' }}" alt=""> 
               </div>
               <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->nama_lengkap }}</span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
               <li class="dropdown-header">
                  <img src="{{ Auth::user()->photo ? asset('storage/'. Auth::user()->photo) : 'https://via.placeholder.com/150' }}" style="width: 50px; height: 50px; border-radius: 50%; aspect-ratio: 1/1; object-fit: cover;" alt="">
                  @php
                     $roleName = [1 => 'Admin', 2 => 'user'];
                  @endphp
                  <h6>{{ Auth::user()->nama_lengkap }}</h6>
                  <span>{{ $roleName[Auth::user()->role_id] }}</span>
               </li>
               <li>
                  <hr class="dropdown-divider">
               </li>

               <li>
                  <a class="dropdown-item d-flex align-items-center" href="{{ route('myprofile') }}">
                     <i class="bi bi-person"></i>
                     <span>My Profile</span>
                  </a>
               </li>
               <li>
                  <a id="logout-btn" class="dropdown-item d-flex align-items-center" href="{{ route('logout.post') }}" >
                     <i class="bi bi-box-arrow-right"></i>
                     <span>Sign Out</span>
                  </a>
               </li>
            </ul><!-- End Profile Dropdown Items -->
         </li><!-- End Profile Nav -->
      </ul>
   </nav><!-- End Icons Navigation -->
</header><!-- End Header -->
@if (Auth::user()->role_id == 1)
   @include('pages.admin.sidebar')
@else
   @include('pages.user.sidebar')
@endif
<main id="main" class="main">
   @yield('page-content')
</main>
@endsection