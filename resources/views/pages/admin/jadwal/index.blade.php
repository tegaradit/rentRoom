@extends('layouts.page')

@section('page-content')

<style>
    /* Styling Table */
    .hidden {
        display: none;
        /* This class will hide elements */
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
    }

    .time-slot.booked {
        background-color: #ffcccc;
        pointer-events: auto;
        /* Enable click on booked slots */
    }

    .time-slot.selected {
        background-color: #ffeeba;
    }
</style>

<div class="container my-5">
    <h1>Jadwal Peminjaman Ruangan</h1>

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
                @for ($y = 2023; $y <= 2025; $y++)
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
                <p><strong>nama peminjam:</strong> <span id="booking-user"></span></p>
                <p><strong>keperluan:</strong> <span id="booking-purpose"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteBooking(bookingId)">Delete Booking</button>

            </div>
        </div>
    </div>
</div>


<!-- JavaScript Bootstrap & jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    let FIRST_START = true

    const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    let selectedTimeSlots = [];
    let multiSelectMode = false;
    let startSlot = null;
    let endSlot = null;

    const bookedSlots = JSON.parse('{!! $peminjaman !!}');

    function generateTable() {
        const _year = document.getElementById('year');
        const year = _year.value;

        const _month = document.getElementById('month');
        const month = String(_month.value).padStart(2, '0');

        const _roomId = document.getElementById('room');
        const roomId = _roomId.value;

        localStorage.setItem('curenttime', JSON.stringify({
            year: _year.selectedIndex,
            month: _month.selectedIndex,
            roomId: _roomId.selectedIndex
        }));

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

            for (let hour = 7; hour <= 16; hour++) {
                const timeSlotId = `${dayFormatted}-${month}-${year}-${hour}`;
                let isBooked = false;
                let bookingDetails = null;

                bookedSlots.forEach(slot => {
                    if (
                        slot.ruangan_id == roomId &&
                        slot.tanggal === `${year}-${month}-${dayFormatted}` &&
                        parseInt(slot.jam_mulai) <= hour &&
                        parseInt(slot.jam_selesai) >= hour
                    ) {
                        isBooked = true;
                        bookingDetails = slot;
                    }
                });

                // Log bookingDetails.id to ensure it's not undefined
                if (bookingDetails) {
                    console.log('Booking ID:', bookingDetails.id);
                }

                row += `<td id="${timeSlotId}" class="time-slot ${isBooked ? 'booked' : ''}" 
                    ${isBooked && `onclick="showBookingDetails('${bookingDetails.user_name}', '${bookingDetails.keperluan}', ${bookingDetails.id})"`}>
                    </td>`
            }

            row += '</tr>';
            tbody.innerHTML += row;
        }
    }

    function showBookingModal() {
        if (selectedTimeSlots.length === 0) {
            alert("Please select at least one time slot.");
            return;
        }

        const roomId = document.getElementById('room').value;
        const roomName = document.getElementById('room').selectedOptions[0].text;

        document.getElementById('modal-room-id').value = roomId;
        document.getElementById('modal-room').value = roomName;
        updateSelectedTimeList();
        $('#bookingModal').modal('show');
    }

    function updateSelectedTimeList() {
        document.getElementById('selected-times-list').innerHTML = selectedTimeSlots.map(slot => `<li>${slot}</li>`).join('');
        document.getElementById('selected_dates').value = JSON.stringify(selectedTimeSlots);
    }

    let bookingId = null;

    function showBookingDetails(namaPeminjam, keperluan, id) {
        document.getElementById('booking-user').textContent = namaPeminjam;
        document.getElementById('booking-purpose').textContent = keperluan || "Tidak ada keperluan yang tercatat";

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
                success: function (response) {
                    $('#showBookingModal').modal('hide');
                    alert('Booking deleted successfully');
                    window.location.reload();
                },
                error: function (err) {
                    console.log(err);
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