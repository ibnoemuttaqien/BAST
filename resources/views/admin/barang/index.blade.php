@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
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
        <h2 class="mb-4">Daftar Barang</h2>
        <hr>
        <!-- Button to trigger create barang modal -->
        <button type="button" class="btn btn-primary mb-3" onclick="openModal('createBarangModal')">
            <i class="fas fa-plus"></i> Tambah Barang
        </button>

        <!-- Barang Table -->

        <div class="table-responsive">
            <table id="table-ok" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Ukuran</th>
                        <th>Kategori Pembuatan</th>
                        <th>Kategori Grade</th>
                        <th>Stok</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang->nama }}</td>
                            <td>{{ $barang->deskripsi }}</td>
                            <td>{{ $barang->ukuran }}</td>
                            <td>{{ $barang->kategoriPembuatan->nama }}</td>
                            <td>{{ $barang->kategoriGrade->nama }}</td>
                            <td>{{ $barang->stok }}</td>
                            <td>{{ $barang->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm mb-2"
                                    onclick="openEditModal('{{ $barang->id }}', '{{ $barang->nama }}', '{{ $barang->deskripsi }}', '{{ $barang->ukuran }}', '{{ $barang->kategori_pembuatan_id }}', '{{ $barang->kategori_grade_id }}', '{{ $barang->stok }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ $barang->id }}')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Barang Modal -->
    <div id="createBarangModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('createBarangModal')">&times;</span>
            <h2>Tambah Barang</h2>
            <form action="{{ route('admin.barang.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Barang</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label><span class="text-info"> (Opsional)</span>
                    <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                </div>
                <div class="form-group">
                    <label for="ukuran">Ukuran</label><span class="text-info"> (Opsional)</span>
                    <input type="text" class="form-control" id="ukuran" name="ukuran">
                </div>
                <div class="form-group">
                    <label for="kategori_pembuatan_id">Kategori Pembuatan</label><span class="text-danger">*</span>
                    <select class="form-control" id="kategori_pembuatan_id" name="kategori_pembuatan_id" required>
                        @foreach ($kategoriPembuatan as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="kategori_grade_id">Kategori Grade</label><span class="text-danger">*</span>
                    <select class="form-control" id="kategori_grade_id" name="kategori_grade_id" required>
                        @foreach ($kategoriGrade as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label><span class="text-danger">*</span>
                    <input type="number" class="form-control" id="stok" name="stok" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Edit Barang Modal -->
    <div id="editBarangModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('editBarangModal')">&times;</span>
            <h2>Edit Barang</h2>
            <form id="editBarangForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_nama">Nama Barang</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="edit_nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="edit_deskripsi">Deskripsi</label><span class="text-info"> (Opsional)</span>
                    <input type="text" class="form-control" id="edit_deskripsi" name="deskripsi">
                </div>
                <div class="form-group">
                    <label for="edit_ukuran">Ukuran</label><span class="text-info"> (Opsional)</span>
                    <input type="text" class="form-control" id="edit_ukuran" name="ukuran">
                </div>
                <div class="form-group">
                    <label for="edit_kategori_pembuatan_id">Kategori Pembuatan</label><span class="text-danger">*</span>
                    <select class="form-control" id="edit_kategori_pembuatan_id" name="kategori_pembuatan_id" required>
                        @foreach ($kategoriPembuatan as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_kategori_grade_id">Kategori Grade</label><span class="text-danger">*</span>
                    <select class="form-control" id="edit_kategori_grade_id" name="kategori_grade_id" required>
                        @foreach ($kategoriGrade as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_stok">Stok</label><span class="text-danger">*</span>
                    <input type="number" class="form-control" id="edit_stok" name="stok" required>
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
            <p>Apakah Anda yakin ingin menghapus barang ini?</p>
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
        // Function to open a modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        // Function to close a modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        // Function to open the edit modal and populate it with barang data
        function openEditModal(id, nama, deskripsi, ukuran, kategori_pembuatan_id, kategori_grade_id, stok) {
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('edit_ukuran').value = ukuran;
            document.getElementById('edit_stok').value = stok;

            // Update the select options
            let edit_kategori_pembuatan = document.getElementById('edit_kategori_pembuatan_id');
            let edit_kategori_grade = document.getElementById('edit_kategori_grade_id');

            for (let option of edit_kategori_pembuatan.options) {
                if (option.value == kategori_pembuatan_id) {
                    option.selected = true;
                } else {
                    option.selected = false;
                }
            }
            for (let option of edit_kategori_grade.options) {
                if (option.value == kategori_grade_id) {
                    option.selected = true;
                } else {
                    option.selected = false;
                }
            }

            // Update the form action to point to the correct route
            document.getElementById('editBarangForm').action = `/admin/barang/${id}`;
            openModal('editBarangModal');
        }

        // Function to open the delete confirmation modal
        function openDeleteModal(id) {
            // Set the form action to the delete route
            document.getElementById('deleteForm').action = `/admin/barang/${id}`;
            // Open the delete confirmation modal
            openModal('deleteConfirmationModal');
        }
    </script>
@endsection
