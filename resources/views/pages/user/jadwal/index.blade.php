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

    .time-slot.past {
        color: #888;
        background-color: #ddd;
        pointer-events: none;
    }
</style>

<div class="container my-5">
    <h1>Jadwal Peminjaman Ruangan</h1>
    <p class="text-warning"><strong>Perhatian:</strong> Peminjaman ruangan dilakukan per 1 jam. Misalnya, peminjaman
        mulai jam 7 akan selesai pada jam 7.59, dan jam 8 akan selesai pada jam 8.59.</p>

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

    <!-- Multi-select and Booking buttons -->
    <button id="multiSelectBtn" class="btn btn-primary mb-3" onclick="toggleMultiSelect()">Enable Multi-Select</button>
    <button id="bookSelectedBtn" class="btn btn-success mb-3" onclick="showBookingModal()" style="display: none;">Book
        Selected</button>

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

<!-- Modal for booking confirmation -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('peminjaman.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Confirm Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modal-time">Selected Times:</p>
                    <ul id="selected-times-list"></ul>
                    <input type="hidden" name="selected_dates" id="selected_dates">

                    <div class="form-group">
                        <label for="modal-room">Room Name</label>
                        <input type="text" class="form-control" id="modal-room" name="room_name" readonly>
                        <input type="hidden" id="modal-room-id" name="room_id">
                    </div>
                    <div class="form-group">
                        <label for="user">Nama peminjam</label>
                        <input type="text" class="form-control" name="user_name" id="user" required>
                    </div>
                    <div class="form-group">
                        <label for="keperluan">keperluan</label>
                        <input type="text" class="form-control" id="keperluan" name="keperluan">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
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
                <p><strong>status:</strong> <span id="booking-status"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript Bootstrap & jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    let FIRST_START = true

    const colors = ["#FF6666", "#FFB266", "#FFDA66", "#66FF66", "#66FFDA", "#66B2FF", "#DA66FF", "#FF66B2"];
    const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    let selectedTimeSlots = [];
    let multiSelectMode = false;
    let startSlot = null;
    let endSlot = null;

    const bookedSlots = JSON.parse(`{!! $peminjaman !!}`);

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
        const today = new Date(); // Tanggal saat ini
        today.setHours(0, 0, 0, 0); // Set waktu ke awal hari

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
                let slotColor = "#f0f0f0"; // Default color for available slots
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
                        slotColor = colors[index % colors.length]; // Use color based on index
                        colspan = parseInt(slot.jam_selesai) - parseInt(slot.jam_mulai) + 1;
                    }
                });

                if (isBooked) {
                    const status = {
                        pending: { color: 'yellow', title: 'pendding' },
                        approved: { color: 'green', title: 'diterima' },
                        rejected: { color: 'red', title: 'ditolak' }
                    }
                    // Jika sudah dibooking, tampilkan dengan warna sesuai
                    row += `
                        <td 
                            colspan="${colspan}" class="time-slot booked" 
                            style="background-color: ${slotColor}; position: relative;"
                            onclick="showBookingDetails('${bookingDetails.user_name}', '${bookingDetails.keperluan}', ${bookingDetails.id}, '${bookingDetails.status}')"
                        >
                            ${bookingDetails.user_name}
                            <div style="position: absolute; right: .3rem; top: .3rem; border: solid white 1px; background-color: ${status[bookingDetails.status].color}; width: .75rem; height: .75rem; border-radius: 50%; cursor: pointer" title="${status[bookingDetails.status].title}"></div>
                        </td>`;
                    hour += colspan; // Lewati jam yang sudah dibooking
                } else {
                    // Cek apakah tanggal adalah tanggal di bawah hari ini
                    const isPastDate = date < today;

                    if (isPastDate) {
                        // Jika tanggal sudah lewat, tampilkan slot dengan warna abu-abu dan non-klik
                        const slotTime = `${hour}:00 - ${hour}:59`;
                        const timeSlotId = `${dayFormatted}-${month}-${year}-${hour}`;
                        row += `<td id="${timeSlotId}" class="time-slot" style="background-color: #d3d3d3; cursor: not-allowed;" title="Tanggal ini tidak dapat dibooking.">
                                ${slotTime}
                            </td>`;
                        hour++; // Lanjutkan ke jam berikutnya
                    } else {
                        // Tampilkan slot yang dapat dibooking
                        const slotTime = `${hour}:00 - ${hour}:59`;
                        const timeSlotId = `${dayFormatted}-${month}-${year}-${hour}`;
                        row += `<td id="${timeSlotId}" class="time-slot" onclick="selectTimeSlot('${timeSlotId}')">
                                ${slotTime}
                            </td>`;
                        hour++;
                    }
                }
            }

            row += '</tr>';
            tbody.innerHTML += row;
        }
    }


    function toggleMultiSelect() {
        multiSelectMode = !multiSelectMode;
        const multiSelectBtn = document.getElementById('multiSelectBtn');
        multiSelectBtn.classList.toggle('btn-warning', multiSelectMode);
        multiSelectBtn.classList.toggle('btn-primary', !multiSelectMode);
        multiSelectBtn.textContent = multiSelectMode ? 'Disable Multi-Select' : 'Enable Multi-Select';
        document.getElementById('bookSelectedBtn').style.display = multiSelectMode ? 'inline-block' : 'none';

        // Unselect all selected time slots when multi-select is disabled
        const tbody = document.getElementById('schedule-body');
        const selectedSlots = tbody.querySelectorAll('.selected');

        if (!multiSelectMode) {
            selectedSlots.forEach(slot => {
                slot.classList.remove('selected'); // Unselect the slots when multi-select is disabled
            });
        } else {
            // If multi-select is enabled, you may want to show hidden slots or do other actions
            selectedSlots.forEach(slot => {
                slot.classList.remove('hidden'); // Show selected slots when multi-select is enabled
            });
        }
    }


    function selectTimeSlot(timeSlotId, timeDisplay) {
        if (!multiSelectMode) {
            startSlot = endSlot = timeSlotId;
            selectedTimeSlots = [timeSlotId];
            updateSelectedTimeList();
            showBookingModal();
        } else {
            if (startSlot && endSlot) {
                const rangeSlots = getRangeSlots(startSlot, endSlot);
                rangeSlots.forEach(slot => {
                    const slotElement = document.getElementById(slot);
                    if (slotElement) {
                        slotElement.classList.remove('selected');
                    }
                });
                selectedTimeSlots = selectedTimeSlots.filter(slot => !rangeSlots.includes(slot)); // Remove previously selected
                startSlot = endSlot = null; // Reset slots
            }

            if (!startSlot) {
                startSlot = timeSlotId;
                selectedTimeSlots.push(timeSlotId);
                const slotElement = document.getElementById(timeSlotId);
                slotElement.classList.add('selected');
                slotElement.classList.remove('hidden'); // Ensure it is shown
            } else {
                endSlot = timeSlotId;
                const rangeSlots = getRangeSlots(startSlot, endSlot);
                rangeSlots.forEach(slot => {
                    const slotElement = document.getElementById(slot);
                    if (slotElement && !selectedTimeSlots.includes(slot)) {
                        selectedTimeSlots.push(slot);
                        slotElement.classList.add('selected');
                        slotElement.classList.remove('hidden'); // Ensure it is shown
                    }
                });
            }
        }
    }

    function getRangeSlots(startId, endId) {
        const [startDay, startMonth, startYear, startHour] = startId.split('-');
        const [endDay, endMonth, endYear, endHour] = endId.split('-');

        const slotsInRange = [];
        const startHourNum = parseInt(startHour);
        const endHourNum = parseInt(endHour);

        const startDate = new Date(`${startYear}-${startMonth}-${startDay}T00:00:00`);
        const endDate = new Date(`${endYear}-${endMonth}-${endDay}T00:00:00`);

        for (let hour = startHourNum; hour <= endHourNum; hour++) {
            for (let dayOffset = 0; dayOffset <= Math.abs((endDate - startDate) / (1000 * 60 * 60 * 24)); dayOffset++) {
                const currentDate = new Date(startDate);
                currentDate.setDate(startDate.getDate() + dayOffset);
                const day = String(currentDate.getDate()).padStart(2, '0');
                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                const year = currentDate.getFullYear();
                slotsInRange.push(`${day}-${month}-${year}-${hour}`);
            }
        }
        return slotsInRange;
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
        document.getElementById('selected-times-list').innerHTML = selectedTimeSlots.map(slot => `<li>${slot}:00</li>`).join('');
        document.getElementById('selected_dates').value = JSON.stringify(selectedTimeSlots);
    }

    function showBookingDetails(namaPeminjam, keperluan, id, status) {
        document.getElementById('booking-user').textContent = namaPeminjam;
        document.getElementById('booking-status').textContent = status;
        document.getElementById('booking-purpose').textContent = keperluan || "Tidak ada keperluan yang tercatat";
        $('#showBookingModal').modal('show');
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