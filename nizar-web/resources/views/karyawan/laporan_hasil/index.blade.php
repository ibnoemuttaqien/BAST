@extends('layouts.karyawan')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h1 class="m-0">Laporan Hasil</h1>
        </div>
        <hr>
        <!-- Clock -->
        <div id="clock" class="text-center mb-4">
            <p id="date" class="h4"></p>
            <p id="time" class="h4"></p>
        </div>

        <!-- Date Filter Form -->
        <div class="mb-4">
            <form id="filterForm" method="GET">
                <div class="form-row">
                    <div class="col-md-4 mb-2">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                    <div class="col-md-4 mb-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-2">Filter</button>
                        <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset</button>
                    </div>
                </div>
            </form>
            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-secondary" onclick="filterByWeek()">Lihat Minggu Ini</button>
                <button type="button" class="btn btn-secondary" onclick="filterByMonth()">Lihat Bulan Ini</button>
            </div>
        </div>

        <!-- Add Laporan Hasil Button -->
        <div class="mb-4 text-right">
            <button type="button" class="btn btn-primary" onclick="openModal('createLaporanHasilModal')">
                Tambah Laporan Hasil
            </button>
        </div>

        <!-- Laporan Hasil Table -->
        <div class="table-responsive">
            <table id="table-ok" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Deskripsi</th>
                        <th>Kategori Pembuatan</th>
                        <th>Grade</th>
                        <th>File</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanHasils as $laporanHasil)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $laporanHasil->barang->nama }}</td>
                            <td>{{ $laporanHasil->deskripsi }}</td>
                            <td>{{ $laporanHasil->barang->kategoriPembuatan->nama ?? 'N/A' }}</td>
                            <td>{{ $laporanHasil->barang->kategoriGrade->nama ?? 'N/A' }}</td>
                            <td>
                                @if ($laporanHasil->file)
                                    <a href="{{ asset($laporanHasil->file) }}" target="_blank">View File</a>
                                @else
                                    N/A
                                @endif
                            </td>

                            <td>{{ \Carbon\Carbon::parse($laporanHasil->created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    onclick="openEditModal('{{ $laporanHasil->id }}')">Edit</button>
                                <button class="btn btn-danger btn-sm"
                                    onclick="openDeleteModal('{{ $laporanHasil->id }}')">Delete</button>
                            </td>
                        </tr>
                    @empty

                        <p class="text-center">No records found</p>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Laporan Hasil Modal -->
    <div id="createLaporanHasilModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('createLaporanHasilModal')">&times;</span>
            <h2>Tambah Laporan Hasil</h2>
            <form action="{{ route('karyawan.laporan_hasil.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="id_barang">Pilih Barang</label><span class="text-danger">*</span>
                    <select class="form-control" id="id_barang" name="id_barang" required>
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->id }}">
                                {{ $barang->nama }} - Stok: {{ $barang->stok }} - Ukuran: {{ $barang->ukuran }} -
                                Kategori Pembuatan: {{ $barang->kategoriPembuatan->nama ?? 'N/A' }} -
                                Grade: {{ $barang->kategoriGrade->nama ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="deskripsi">Deskripsi Laporan<span class="text-danger">*</span></label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="file">File<span class="text-info"> (Opsional)</span></label>
                    <input type="file" class="form-control" id="file" name="file" accept=".jpg,.png,.pdf">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Edit Laporan Hasil Modal -->
    <div id="editLaporanHasilModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('editLaporanHasilModal')">&times;</span>
            <h2>Edit Laporan Hasil</h2>
            <form id="editLaporanHasilForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_barang_id">Pilih Barang<span class="text-danger">*</span></label>
                    <select class="form-control" id="edit_barang_id" name="id_barang" required>
                        <!-- Options will be dynamically populated by JavaScript -->
                    </select>
                    <p id="barang_info"></p> <!-- Menampilkan informasi tambahan tentang barang -->
                </div>

                <div class="form-group">
                    <label for="edit_deskripsi">Deskripsi Laporan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit_deskripsi" name="deskripsi" required>
                </div>
                <div class="form-group">
                    <label for="edit_file">File<span class="text-info"> (Opsional)</span></label>
                    <input type="file" class="form-control" id="edit_file" name="file" accept=".jpg,.png,.pdf">
                    <p id="currentFileLink"></p>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>



    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('deleteConfirmationModal')">&times;</span>
            <h2>Konfirmasi Penghapusan</h2>
            <p>Apakah Anda yakin ingin menghapus laporan ini?</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="closeModal('deleteConfirmationModal')">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function resetFilters() {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            document.getElementById('filterForm').submit();
            window.location.href = '{{ route('karyawan.laporan_hasil.index') }}';
        }

        function filterByWeek() {
            const today = new Date();
            const startOfWeek = new Date(today.setDate(today.getDate() - today.getDay() + 1)).toISOString().split('T')[0];
            const endOfWeek = new Date(today.setDate(today.getDate() - today.getDay() + 7)).toISOString().split('T')[0];
            document.getElementById('start_date').value = startOfWeek;
            document.getElementById('end_date').value = endOfWeek;
            document.getElementById('filterForm').submit();
        }

        function filterByMonth() {
            const today = new Date();
            const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
            const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
            document.getElementById('start_date').value = startOfMonth;
            document.getElementById('end_date').value = endOfMonth;
            document.getElementById('filterForm').submit();
        }


        // Function to open a modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        // Function to close a modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function openEditModal(id) {
            fetch(`/karyawan/laporan_hasil/${id}/edit`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data); // Periksa struktur data

                    // Isi deskripsi
                    document.getElementById('edit_deskripsi').value = data.laporanHasil.deskripsi;

                    // Isi dropdown barang
                    let barangSelect = document.getElementById('edit_barang_id');
                    barangSelect.innerHTML = '';
                    data.barangs.forEach(barang => {
                        let kategoriPembuatan = barang.kategori_pembuatan ? barang.kategori_pembuatan.nama :
                            'N/A';
                        let kategoriGrade = barang.kategori_grade ? barang.kategori_grade.nama : 'N/A';
                        let option = document.createElement('option');
                        option.value = barang.id;
                        option.text =
                            `${barang.nama} - Stok: ${barang.stok} - Ukuran: ${barang.ukuran} - Kategori Pembuatan: ${kategoriPembuatan} - Kategori Grade: ${kategoriGrade}`;
                        if (barang.id == data.laporanHasil.id_barang) {
                            option.selected = true;
                        }
                        barangSelect.add(option);
                    });

                    // Update currentFileLink dengan URL file
                    document.getElementById('currentFileLink').innerHTML = data.fileUrl ?
                        `<a href="${data.fileUrl}" target="_blank">View File</a>` : '';

                    // Update action form
                    document.getElementById('editLaporanHasilForm').action = `/karyawan/laporan_hasil/${id}`;

                    // Buka modal
                    openModal('editLaporanHasilModal');
                })
                .catch(error => console.error('Error fetching data:', error));
        }








        // Function to open the delete confirmation modal
        function openDeleteModal(id) {
            // Set the form action to the delete route
            document.getElementById('deleteForm').action = `/karyawan/laporan_hasil/${id}`;

            // Open the delete confirmation modal
            openModal('deleteConfirmationModal');
        }
    </script>
    <script>
        function updateClock() {
            const now = new Date();

            // Format tanggal
            const date = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            // Format waktu
            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            // Update elemen dengan tanggal dan waktu
            document.getElementById('date').textContent = date;
            document.getElementById('time').textContent = time;
        }

        // Perbarui jam setiap detik
        setInterval(updateClock, 1000);

        // Panggil updateClock sekali untuk menampilkan waktu saat halaman dimuat
        updateClock();
    </script>

@endsection
