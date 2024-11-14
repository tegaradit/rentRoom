@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Data Laporan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Laporan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <form method="GET" action="{{ route('laporan.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal"
                        value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-danger">
                        <i class="bi bi-eraser me-1"></i> Bersihkan
                    </a>
                </div>
            </div>
        </form>

        <button class="btn btn-danger" onclick="exportToPDF()"><i class="bi bi-filetype-pdf"></i> Export to PDF</button>

        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <table id="tableID" class="table datatable table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Keperluan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->nama_peminjam }}</td>
                            <td>{{ $data->ruangan->nama_ruangan }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tgl_peminjaman)->format('d-m-Y') }}</td>
                            <td>{{ $data->waktu_mulai }}</td>
                            <td>{{ $data->waktu_selesai }}</td>
                            <td>{{ $data->keperluan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center alert alert-danger">Data Laporan masih Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- jsPDF dan autoTable -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.21/jspdf.plugin.autotable.min.js"></script>
        <script>
            async function exportToPDF() {
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF();

                // URL gambar
                const imageUrl = '{{ asset('assets/themes/nice/img/logo smenza.png') }}';
                const imgBase64 = await getBase64ImageFromUrl(imageUrl);
                doc.addImage(imgBase64, 'PNG', 22, 10, 25, 25);

                // Kop surat di kanan
                doc.setFontSize(12);
                doc.setFont("times", "bold");

                const pageWidth = doc.internal.pageSize.width;
                const centerX = pageWidth / 2;
                const offsetX = 10;

                function centerText(text, yPosition, offsetX = 0) {
                    const textWidth = doc.getTextWidth(text);
                    doc.text(text, centerX - textWidth / 2 + offsetX, yPosition);
                }

                centerText('PEMERINTAH PROVINSI JAWA TENGAH', 15, offsetX);
                centerText('DINAS PENDIDIKAN DAN KEBUDAYAAN', 21, offsetX);
                centerText('SEKOLAH MENENGAH KEJURUAN NEGERI 1 KEBUMEN', 27, offsetX);

                doc.setFontSize(11);
                doc.setFont("times", "normal");
                centerText('Jalan Cemara No.37 Karangsari Kebumen Kode Pos 54351 Telepon 0287-381132', 33, offsetX);
                centerText('Faksimile 0287-381132 Surat Elektronik: smkn1.kebumen@yahoo.com', 37, offsetX);

                // Menambahkan garis bawah ganda
                const lineYPosition1 = 40;
                doc.setLineWidth(0.5);
                doc.line(20, lineYPosition1, pageWidth - 20, lineYPosition1);

                // Menambahkan judul laporan
                doc.setFontSize(12);
                doc.setFont("times", "bold");
                const title = 'Laporan Peminjaman Ruangan';
                const textWidth = doc.getTextWidth(title); 
                doc.text(title, centerX - textWidth / 2, 55);

                const data = JSON.parse('{!! $datas !!}').map((item, ix) => [
                    `${ix + 1}`,
                    item.nama_peminjam,
                    item.ruangan.nama_ruangan,
                    item.tgl_peminjaman,
                    item.waktu_mulai,
                    item.waktu_selesai,
                    item.keperluan,
                ]);

                let startY = 63;
                doc.autoTable({
                    head: [
                        ['No', 'Peminjam', 'Ruangan', 'Tanggal Peminjaman', 'Waktu Mulai', 'Waktu Selesai',
                            'Keperluan'
                        ],
                    ],
                    body: data,
                    startY: startY,
                    theme: 'striped',
                    margin: {
                        top: 10
                    },
                    styles: {
                        halign: 'center'
                    },
                    headStyles: {
                        halign: 'center'
                    },
                    pageBreak: 'auto',
                    didDrawPage: function(data) {
                        if (data.pageNumber > 1) {
                            doc.addImage(imgBase64, 'PNG', 22, 10, 25, 25);
                            doc.setFontSize(12);
                            doc.setFont("times", "bold");
                            centerText('PEMERINTAH PROVINSI JAWA TENGAH', 15, offsetX);
                            centerText('DINAS PENDIDIKAN DAN KEBUDAYAAN', 21, offsetX);
                            centerText('SEKOLAH MENENGAH KEJURUAN NEGERI 1 KEBUMEN', 27, offsetX);

                            doc.setFontSize(11);
                            doc.setFont("times", "normal");
                            centerText(
                                'Jalan Cemara No.37 Karangsari Kebumen Kode Pos 54351 Telepon 0287-381132',
                                33,
                                offsetX
                            );
                            centerText(
                                'Faksimile 0287-381132 Surat Elektronik: smkn1.kebumen@yahoo.com',
                                37,
                                offsetX
                            );

                            // Garis bawah ganda
                            const lineYPosition1 = 45;
                            doc.setDrawColor(0, 0, 0);
                            doc.setLineWidth(0.5);
                            doc.line(20, lineYPosition1, pageWidth - 20, lineYPosition1);
                            doc.addPage(); 

                            // Garis bawah pada halaman baru
                            if (data.pageNumber > 1) {
                                const lineYPositionNext = data.cursor.y-5; 
                                doc.setLineWidth(0.5); 
                                doc.setDrawColor(0, 0, 0);
                                doc.line(20, lineYPositionNext, pageWidth - 20,
                                lineYPositionNext); 
                            }
                            startY = lineYPosition1 + 10;
                        }
                        data.settings.margin.top = startY;
                        data.cursor.y = startY; 
                    },
                    didDrawCell: function(data) {
                        const pageHeight = doc.internal.pageSize.height;
                        const endY = data.table.finalY;
                        const signatureHeight = 50;

                        if (endY + signatureHeight > pageHeight) {
                            doc.addPage(); 
                        }
                    },
                });

                // Menambahkan tanda tangan
                const pageHeight = doc.internal.pageSize.height;
                const signatureX = pageWidth - 70;
                doc.setFontSize(12);
                doc.text('Kebumen, ........................', signatureX, pageHeight - 67);
                doc.text('Mengetahui:', signatureX + 10, pageHeight - 60);
                doc.text('(......................................)', signatureX, pageHeight - 30);

                // Simpan PDF
                doc.save('Laporan_Peminjaman.pdf');
            }

            function getBase64ImageFromUrl(url) {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.crossOrigin = 'Anonymous';
                    img.src = url;
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0);
                        const dataURL = canvas.toDataURL('image/png');
                        resolve(dataURL);
                    };
                    img.onerror = error => reject(error);
                });
            }
        </script>


    </section>
@endsection
