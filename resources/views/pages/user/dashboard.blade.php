@extends('layouts.page')

@section('page-content')
<section class="section dashboard">
   <div>
      <div class="col-lg-8 w-100 mb-3">
         <div class="row">
            <div class="col-xxl-3 col-md-6" style="height: fit-content !important; min-height: 0 !important;">
               <div class="card info-card h-100 sales-card px-3">
                  <div class="card-body">
                     <h5 class="card-title">Ruangan Tersedia</h5>
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
                     <h5 class="card-title">Total Peminjaman</h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-box"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ $totalBorrowing }}</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xxl-3 col-md-6" style="height: fit-content !important; min-height: 0 !important;">
               <div class="card info-card h-100 customers-card px-3">
                  <div class="card-body">
                     <h5 class="card-title">Pinjaman di Setujui</h5>

                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-circle"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ $acceptedBorrowing }}</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xxl-3 col-md-6" style="height: fit-content !important; min-height: 0 !important;">
               <div class="card info-card h-100 customers-card px-3">
                  <div class="card-body">
                     <h5 class="card-title">Pinjaman Di Tolak</h5>

                     <div class="d-flex align-items-center">
                        <div style="background-color: rgba(255,0,0,.1);" class="text-danger card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-trash"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ $rejectedBorrowing }}</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <section class="section guru">
         <div class="col-lg-12">
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
                        <th>Status</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse ($roomBorrowed as $borrowed)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $borrowed->nama_ruangan }}</td>
                        <td>{{ $borrowed->tgl_peminjaman }}</td>
                        <td>{{ $borrowed->waktu_mulai }}</td>
                        <td>{{ $borrowed->waktu_selesai }}</td>
                        <td>
                           @if ($borrowed->status == 'diterima')
                              @php
                                 $startTime = \Carbon\Carbon::parse($borrowed->waktu_mulai);
                                 $endTime = \Carbon\Carbon::parse($borrowed->waktu_selesai);
                                 $remainingTime = $endTime->diffForHumans($startTime, true);
                              @endphp
                              {{ $remainingTime }}
                           @else
                           -
                           @endif
                        </td>
                        <td><span class="badge bg-info">{{ $borrowed->status }}</span></td>
                        <td>
                           @if ($borrowed->status == 'pending')
                              <button class="btn btn-danger btn-sm">
                                 <i class="fas fa-times"></i> Batalkan
                              </button>
                           @else
                              -
                           @endif
                        </td>
                     </tr>
                     @empty
                        <h2 class="text-center">Belum Ada Peminjaman</h2>
                     @endforelse
                  </tbody>
               </table>
            </div>
         </div>
      </section>
   </div>
</section>
@endsection