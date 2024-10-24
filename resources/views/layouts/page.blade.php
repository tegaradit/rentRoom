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
               <div
                  style="border-radius: 50%; width: 2.5rem; height: 2.5rem; background-color: gray; text-align: center; line-height: 2.5rem; color: white">
                  Ad</div>
               <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
            </a><!-- End Profile Iamge Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
               <li class="dropdown-header">
                  <h6>Admin</h6>
                  <span>Admin</span>
               </li>
               <li>
                  <hr class="dropdown-divider">
               </li>

               <li>
                  <a class="dropdown-item d-flex align-items-center" href="http://simlogbookdiklat.test/my_profile">
                     <i class="bi bi-person"></i>
                     <span>My Profile</span>
                  </a>
               </li>
               <li>
                  <a id="logout-btn" class="dropdown-item d-flex align-items-center">
                     <i class="bi bi-box-arrow-right"></i>
                     <span>Sign Out</span>
                  </a>
               </li>
            </ul><!-- End Profile Dropdown Items -->
         </li><!-- End Profile Nav -->
      </ul>
   </nav><!-- End Icons Navigation -->
</header><!-- End Header -->
@include('pages.admin.sidebar')
<main id="main" class="main">
   @yield('page-content')
</main>
@endsection