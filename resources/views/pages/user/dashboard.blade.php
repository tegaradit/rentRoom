@extends('layouts.root')

@section('root-content')
<section class="section dashboard">
   <div class="container mt-4">
      <div class="col-lg-8 w-100 mb-3">
         <div class="row">
            <div class="col-xxl-3 col-md-6">
               <div class="card info-card h-100 sales-card">
                  <div class="card-body">
                     <h5 class="card-title">Peminjaman</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                           <h6>117</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xxl-3 col-md-6">
               <div class="card info-card h-100 revenue-card">
                  <div class="card-body">
                     <h5 class="card-title">Disetujui</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-book"></i>
                        </div>
                        <div class="ps-3">
                           <h6>4</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xxl-3 col-md-6">
               <div class="card info-card h-100 customers-card">
                  <div class="card-body">
                     <h5 class="card-title">Tidak di Setujui</h5>

                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ps-3">
                           <h6>0</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xxl-3 col-md-6">
               <div class="card info-card h-100 customers-card">
                  <div class="card-body">
                     <h5 class="card-title">Di Batalkan</h5>

                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ps-3">
                           <h6>0</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <section class="section guru">
         <div class="col-lg-12">
            <a href="http://simlogbookdiklat.test/admin/manage_guru/create" class="btn btn-primary">
               Lihat Riwayat
            </a>

            <div class="table-responsive">
               <table class="table datatable table-stripped">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Ruangan</th>
                        <th>Tanggal peminjaman</th>
                        <th>Waktu mulai</th>
                        <th>Waktu selesai</th>
                        <th>Sisa waktu</th>
                        <th>Keperluan</th>
                        <th>Jaminan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>1</td>
                        <td>Lab Multimedia</td>
                        <td>2023-08-14</td>
                        <td>15:00</td>
                        <td>15:06</td>
                        <td>-</td>
                        <td>Lomba</td>
                        <td>KTM</td>
                        <td><span class="badge bg-warning">PENDING</span></td>
                        <td>
                           <button class="btn btn-danger btn-sm">
                              <i class="fas fa-times"></i> Batalkan
                           </button>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </section>
   </div>
</section>
@endsection