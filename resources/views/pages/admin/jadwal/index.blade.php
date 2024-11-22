@extends('layouts.page')

@section('page-content')

<style>
    .hidden {
        display: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        border: 1px solid #ccc;
        text-align: center;
    }

    .time-slot {
        background-color: #f0f0f0;
        cursor: pointer;
        color: white;
    }

    .time-slot.booked {
        font-weight: bold;
    }

    .time-slot.selected {
        background-color: #ffeeba;
    }
</style>

<div class="container my-5">
    <h1>Jadwal Peminjaman Ruangan</h1>

    <!-- Peringatan tentang durasi peminjaman -->
    <p class="text-warning"><strong>Perhatian:</strong> Peminjaman ruangan dilakukan per 1 jam. Misalnya, peminjaman mulai jam 7 akan selesai pada jam 7.59, dan jam 8 akan selesai pada jam 8.59.</p>

    <!-- Dropdown untuk memilih ruangan -->
    <div class="form-row mb-4">
        <div class="col">
            <label for="room">Pilih Ruangan:</label>
            <select id="room" class="form-control" onchange="generateTable()">
                @foreach ($ruangan as $room)
                    <option value="{{ $room->id }}">{{ $room->nama_ruangan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <label for="year">Pilih Tahun:</label>
            <select id="year" class="form-control" onchange="generateTable()">
                @for ($y = 2024; $y <= 2030; $y++)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col">
            <label for="month">Pilih Bulan:</label>
            <select id="month" class="form-control" onchange="generateTable()">
                @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $month)
                    <option value="{{ $index + 1 }}">{{ $month }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Hari</th>
                @for ($hour = 7; $hour <= 16; $hour++)
                    <th>{{ sprintf('%02d:00', $hour) }}</th>
                @endfor
            </tr>
        </thead>
        <tbody id="schedule-body">
            <!-- Konten tabel akan diisi oleh JavaScript berdasarkan tahun, bulan, dan ruangan yang dipilih -->
        </tbody>
    </table>
</div>

<!-- Modal for showing booking details -->
<div class="modal fade" id="showBookingModal" tabindex="-1" aria-labelledby="showBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showBookingModalLabel">Booking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Peminjam:</strong> <span id="booking-user"></span></p>
                <p><strong>Keperluan:</strong> <span id="booking-purpose"></span></p>
                <p><strong>status:</strong> <span id="booking-status"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteBooking(bookingId)">Delete Booking</button>
                <form action="{{ route('confirmBooking') }}" method="post" id="decision-form">
                    @method('put')
                    @csrf
                    <input type="hidden" name="id" id="inpBookingId">
                    <input type="submit" name="decision" class="btn btn-success" value="approved" />
                    <input type="submit" name="decision" class="btn btn-warning" value="rejected" />
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for creating a new booking -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Booking Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Ruangan:</strong> <span id="modal-room"></span></p>
                <p><strong>Waktu yang dipilih:</strong> <span id="selected-time-info"></span></p>
                <p class="text-warning"><strong>Catatan:</strong> Peminjaman maksimal 1 jam per slot. Jika Anda memilih mulai jam 7, peminjaman akan selesai pada 7.59.</p>
                <form id="bookingForm">
                    <!-- Additional booking form fields here -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteBooking('asdklm')">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    const inpBookingId = document.getElementById('inpBookingId');
    const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    const bookedSlots = JSON.parse(`{!! $peminjaman !!}`);
    const colors = ["#FF6666", "#FFB266", "#FFDA66", "#66FF66", "#66FFDA", "#66B2FF", "#DA66FF", "#FF66B2"];

    function generateTable() {
        const _year = document.getElementById('year');
        const year = _year.value;

        const _month = document.getElementById('month');
        const month = String(_month.value).padStart(2, '0');

        const _roomId = document.getElementById('room');
        const roomId = _roomId.value;

        localStorage.setItem('curenttime', JSON.stringify({ year: _year.selectedIndex, month: _month.selectedIndex, roomId: _roomId.selectedIndex }));

        const tbody = document.getElementById('schedule-body');
        tbody.innerHTML = '';

        const daysInMonth = new Date(year, month, 0).getDate();

        for (let day = 1; day <= daysInMonth; day++) {
            const dayFormatted = String(day).padStart(2, '0');
            const date = new Date(year, month - 1, day);
            const dayOfWeek = days[date.getDay()];

            let row = `<tr>
                <td>${dayFormatted}/${month}/${year}</td>
                <td>${dayOfWeek}</td>`;

            let hour = 7;
            while (hour <= 16) {
                let isBooked = false;
                let bookingDetails = null;
                let slotColor = "#f0f0f0";
                let colspan = 1;

                bookedSlots.forEach((slot, index) => {
                    if (
                        slot.ruangan_id == roomId &&
                        slot.tanggal === `${year}-${month}-${dayFormatted}` &&
                        parseInt(slot.jam_mulai) <= hour &&
                        parseInt(slot.jam_selesai) >= hour &&
                        slot.status && slot.status != 'rejected'
                    ) {
                        isBooked = true;
                        bookingDetails = slot;
                        slotColor = colors[index % colors.length];

                        colspan = parseInt(slot.jam_selesai) - parseInt(slot.jam_mulai) + 1;
                    }
                });

                if (isBooked) {
                    const status = {
                        pending: { color: 'yellow', title: 'pendding' },
                        approved: { color: 'green', title: 'diterima' },
                        rejected: { color: 'red', title: 'ditolak' }
                    }

                    row += `
                        <td 
                            colspan="${colspan}" class="time-slot booked" 
                            style="background-color: ${slotColor}; position: relative;"
                            onclick="showBookingDetails('${bookingDetails.user_name}', '${bookingDetails.keperluan}', ${bookingDetails.id}, '${bookingDetails.status}')"
                        >
                            ${bookingDetails.user_name}
                            <div style="position: absolute; right: .3rem; top: .3rem; border: solid white .5px; background-color: ${status[bookingDetails.status].color}; width: .75rem; height: .75rem; border-radius: 50%; cursor: pointer" title="${status[bookingDetails.status].title}"></div>
                        </td>`;
                    hour += colspan;
                } else {
                    const slotTime = `${hour}:00 - ${hour}:59`;
                    row += `<td class="time-slot" onclick="showBookingModal('${dayFormatted}', '${month}', '${year}', '${hour}')">
                                ${slotTime}
                            </td>`;
                    hour++;
                }
            }

            row += '</tr>';
            tbody.innerHTML += row;
        }
    }

    function showBookingDetails(namaPeminjam, keperluan, id, status) {
        document.getElementById('booking-user').textContent = namaPeminjam;
        document.getElementById('booking-status').textContent = status;
        document.getElementById('booking-purpose').textContent = keperluan || "Tidak ada keperluan yang tercatat";
        document.getElementById('decision-form').style.display = status != 'pending' ? 'none' : 'block'
        inpBookingId.value = id
        // Set delete button onclick to include the id
        document.querySelector('#showBookingModal .btn-danger').setAttribute('onclick', `deleteBooking(${id})`);


        $('#showBookingModal').modal('show');
    }

    function deleteBooking(id) {
        if (!id) {
            alert('Invalid booking ID');
            return;
        }

        if (confirm('Are you sure you want to delete this booking?')) {
            $.ajax({
                url: `/admin/peminjaman/${id}`, // Ensure a leading slash is here
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#showBookingModal').modal('hide');
                    alert('Booking deleted successfully');
                    window.location.reload();
                },
                error: function(xhr) {
                    alert('Failed to delete booking');
                }
            });
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        const current_time = JSON.parse(localStorage.getItem('curenttime'))
        // console.log(current_time)
        if (current_time instanceof Object) {
            document.getElementById('year').selectedIndex = current_time.year;
            document.getElementById('month').selectedIndex = current_time.month;
            document.getElementById('room').selectedIndex = current_time.roomId;
        }

        generateTable()
    })
</script>
@endsection