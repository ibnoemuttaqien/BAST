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
        <h3 class="mb-4">Daftar Kategori Pembuatan</h3>
        <hr>
        <!-- Button to trigger create category modal -->
        <button type="button" class="btn btn-primary mb-3" onclick="openModal('createCategoryModal')">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>

        <!-- Categories Table -->

        <div class="table-responsive">
            <table id="table-ok" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategoriPembuatan as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->nama }}</td>
                            <td>{{ $category->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm me-2"
                                    onclick="openEditModal('{{ $category->id }}', '{{ $category->nama }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="openDeleteModal('{{ $category->id }}')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Category Modal -->
    <div id="createCategoryModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('createCategoryModal')">&times;</span>
            <h2>Tambah Kategori</h2>
            <form action="{{ route('admin.kategori_pembuatan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Kategori</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('editCategoryModal')">&times;</span>
            <h2>Edit Kategori</h2>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_nama">Nama Kategori</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="edit_nama" name="nama" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('deleteConfirmationModal')">&times;</span>
            <h2>Konfirmasi Penghapusan</h2>
            <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
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

        // Function to open the edit modal and populate it with category data
        function openEditModal(id, nama) {
            document.getElementById('edit_nama').value = nama;

            // Update the form action to point to the correct route
            document.getElementById('editCategoryForm').action = `/admin/kategori_pembuatan/${id}`;
            openModal('editCategoryModal');
        }

        // Function to open the delete confirmation modal
        function openDeleteModal(id) {
            // Set the form action to the delete route
            document.getElementById('deleteForm').action = `/admin/kategori_pembuatan/${id}`;
            // Open the delete confirmation modal
            openModal('deleteConfirmationModal');
        }
    </script>
@endsection
