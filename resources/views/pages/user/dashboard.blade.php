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
                           $currentTime = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
                           $startTime = \Carbon\Carbon::parse($borrowed->waktu_mulai)->format('H:i');
                           $endTime = \Carbon\Carbon::parse($borrowed->waktu_selesai)->format('H:i');
                           $currentDate = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');
                           $borrowingDate = \Carbon\Carbon::parse($borrowed->tgl_peminjaman)->format('Y-m-d');
                           @endphp
                           @if ($borrowingDate >= $currentDate)
                           @if ($currentTime < $startTime)
                              belum mulai
                              @elseif ($currentTime> $endTime)
                              waktu habis
                              @else
                              @php
                              $remainingTimeInMinutes = (strtotime($borrowed->waktu_selesai) - strtotime($currentTime)) / 60;
                              $days = floor($remainingTimeInMinutes / 1440);
                              $hours = floor(($remainingTimeInMinutes % 1440) / 60);
                              $minutes = $remainingTimeInMinutes % 60;
                              $remainingTime = sprintf('%d hari, %02d jam, %02d menit', $days, $hours, $minutes);
                              @endphp
                              {{ $remainingTime }}
                              @endif
                              @else
                              waktu habis
                              @endif
                              @else
                              -
                              @endif
                        </td>
                        <td>
                           @php
                           $statusColor = [
                           'pending' => 'bg-warning',
                           'diterima' => 'bg-success',
                           'ditolak' => 'bg-danger'
                           ];
                           @endphp
                           <span class="badge {{ $statusColor[$borrowed->status] }}">{{ $borrowed->status }}</span>
                        </td>
                        <td>
                           @if ($borrowed->status != 'pending')
                           -
                           @else
                           <button onclick="confirmDelete({{ $borrowed->id }})" class="btn btn-sm btn-danger">Batalkan</button>
                           <form id="delete-form-{{ $borrowed->id }}" action="{{ route('peminjaman_saya.destroy', $borrowed->id) }}" method="POST" style="display: none;">
                              @csrf
                              @method('DELETE')
                           </form>
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
@section('javascript')
<script>
   function confirmDelete(id) {
      Swal.fire({
         title: 'Apakah Anda yakin?',
         text: "Anda tidak akan dapat mengembalikan ini!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Ya',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
         }
      });
   }

   function saveCurrentMonthAndYear(year, month) {
      localStorage.setItem('currentYear', year);
      localStorage.setItem('currentMonth', month);
   }
   document.addEventListener('DOMContentLoaded', function() {
      const currentYear = localStorage.getItem('currentYear');
      const currentMonth = localStorage.getItem('currentMonth');

      if (currentYear && currentMonth) {
         // Fungsi untuk menampilkan bulan dan tahun yang tersimpan
         displayCalendar(currentYear, currentMonth);
      } else {
         // Jika tidak ada data di localStorage, tampilkan bulan dan tahun saat ini
         const today = new Date();
         displayCalendar(today.getFullYear(), today.getMonth() + 1); // bulan dimulai dari 0
      }
   });
</script>
@endsection