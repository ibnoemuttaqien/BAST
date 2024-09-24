@extends('layouts.karyawan')

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h1 class="m-0">Absensi Kehadiran</h1>
        </div>
        <hr>
        <!-- Success and Error Messages -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Current Date and Time -->
        <div id="clock" class="text-center mb-4">
            <p id="date" class="h4"></p>
            <p id="time" class="h4"></p>
        </div>
        <br>
        <center>

            <a href="{{ route('karyawan.absensi.create') }}" class="btn btn-primary">Absen Sekarang</a>
        </center>

        <!-- Filter Form -->
        <div class="mb-4">
            <form method="GET" action="{{ route('karyawan.absensi.index') }}">
                <div class="form-group">
                    <label for="filter_date" class="form-label">Filter by Date:</label>
                    <input type="date" id="filter_date" name="filter_date" class="form-control"
                        value="{{ request('filter_date') }}">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <!-- Absensi Table -->
        @if ($absensis->isEmpty())
            <div class="alert alert-info">No absensi records found.</div>
        @else
            <div class="table-responsive">
                <table id="table-ok" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kehadiran</th>
                            <th>Foto</th>
                            <th>File</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensis as $absensi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ \Carbon\Carbon::parse($absensi->created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}
                                </td>
                                <td>{{ $absensi->kehadiran }}</td>
                                <td>
                                    @if ($absensi->foto)
                                        <img src="{{ asset('absensi/' . $absensi->foto) }}" alt="Foto" width="100">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if ($absensi->file)
                                        <a href="{{ asset($absensi->file) }}" target="_blank">Lihat File</a>
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>{{ $absensi->deskripsi }}</td>
                                <td>
                                    <a href="{{ route('karyawan.absensi.edit', $absensi->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="openDeleteModal('{{ $absensi->id }}')">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('deleteConfirmationModal')">&times;</span>
            <h2>Konfirmasi Penghapusan</h2>
            <p>Apakah Anda yakin ingin menghapus absensi ini?</p>
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


    <!-- JavaScript for Clock -->
    <script>
        function openDeleteModal(id) {
            // Set the form action to the delete route with the specific ID
            const formAction = `/karyawan/absensi/${id}`;
            document.getElementById('deleteForm').action = formAction;

            // Open the delete confirmation modal
            document.getElementById('deleteConfirmationModal').style.display = "block";
        }

        // Function to close the modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function updateClock() {
            const now = new Date();
            const date = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('date').textContent = date;
            document.getElementById('time').textContent = time;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endsection
