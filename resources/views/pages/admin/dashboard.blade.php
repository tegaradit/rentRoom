@extends('layouts.page')

@section('page-content')
<style>
   body {
      background-color: #f8f9fa;
   }

   .chart-container {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      height: 300px;
   }
</style>
<section class="section dashboard">
   <div>
      <div class="col-lg-8 w-100 mb-3">
         <div class="row">
            <div class="col-xxl-3 col-md-6" style="height: fit-content !important; min-height: 0 !important;">
               <div class="card info-card h-100 sales-card px-3">
                  <div class="card-body">
                     <h5 class="card-title">Total Ruangan</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-book"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ $availableRooms }}</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xxl-3 col-md-6" style="height: fit-content !important; min-height: 0 !important;">
               <div class="card info-card h-100 revenue-card px-3">
                  <div class="card-body">
                     <h5 class="card-title">Total Pengguna</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-box"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ $users->count() }}</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xxl-3 col-md-6" style="height: fit-content !important; min-height: 0 !important;">
               <div class="card info-card h-100 customers-card px-3">
                  <div class="card-body">
                     <h5 class="card-title">Total Jurusan</h5>

                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-circle"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ $jurusan->count() }}</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xxl-3 col-md-6" style="height: fit-content !important; min-height: 0 !important;">
               <div class="card info-card h-100 customers-card px-3">
                  <div class="card-body">
                     <h5 class="card-title">Total Peminjaman</h5>

                     <div class="d-flex align-items-center">
                        <div style="background-color: rgba(255,0,0,.1);"
                           class="text-danger card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-trash"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ $totalBorrowingALlUsers->count() }}</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- chart -->
      <div class="row">
         <div class="col-lg-8 mb-4">
            <div class="chart-container">
               <h5>Statistik Peminjaman Ruangan</h5>
               <canvas id="room-stats-chart"></canvas>
            </div>
         </div>
         <div class="col-lg-4 mb-4">
            <div class="chart-container">
               <h5>Pengguna per Jurusan</h5>
               <canvas id="users-per-department-chart"></canvas>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection

@section('javascript')
<script>
   // Room borrowing statistics chart
   const roomStatsCtx = document.getElementById('room-stats-chart').getContext('2d');
   
   const borrowingData = {!! $borrowingByDate !!}
   new Chart(roomStatsCtx, {
      type: 'line',
      data: {
         labels: Object.keys(borrowingData),
         datasets: [{
            label: 'Peminjaman Ruangan',
            data: Object.values(borrowingData).map(data => data.total_peminjaman),
            borderColor: 'teal',
            tension: 0.1
         }]
      },
      options: {
         responsive: true,
         maintainAspectRatio: false,
         scales: {
            y: {
               beginAtZero: true,
               max: 20,
               ticks: {
                  stepSize: 5
               }
            }
         }
      }
   });

   // Users per department chart
   const usersPerDeptCtx = document.getElementById('users-per-department-chart').getContext('2d');
   const userData = {!! $userByJurusan !!}
   new Chart(usersPerDeptCtx, {
      type: 'pie',
      data: {
         labels: userData.map(data => data.nama_jurusan),
         datasets: [{
            data: userData.map(data => data.banyak_pengguna),
            backgroundColor: userData.map(data => data.color)
         }]
      },
      options: {
         responsive: true,
         maintainAspectRatio: false,
         plugins: {
            legend: {
               position: 'bottom'
            }
         }
      }
   });
</script>
@endsection