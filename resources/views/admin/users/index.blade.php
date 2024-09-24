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
        <h2 class="mb-4">Daftar Pengguna</h2>
        <hr>
        <!-- Button to trigger create user modal -->
        <button type="button" class="btn btn-primary mb-3" onclick="openModal('createUserModal')">
            <i class="fas fa-user-plus"></i> Tambah Pengguna
        </button>

        <!-- User Table -->
        <div class="table-responsive">
            <table id="table-ok" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Jenis Kelamin</th>
                        <th>No. Hp</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <img src="{{ asset($user->foto) }}" alt="User Foto" width="50" height="50"
                                    class="img-thumbnail">
                            </td>

                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->jenis_kelamin }}</td>
                            <td>{{ $user->nohp }}</td>
                            <td>{{ $user->alamat }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning mb-2"
                                    onclick="openEditModal('{{ $user->id }}', '{{ $user->username }}', '{{ $user->nama }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->jenis_kelamin }}', '{{ $user->nohp }}', '{{ $user->alamat }}', '{{ $user->foto }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="openDeleteModal('{{ $user->id }}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="createUserModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('createUserModal')">&times;</span>
            <h2>Tambah Pengguna</h2>
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="name">Nama Lengkap</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="name" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label><span class="text-danger">*</span>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label><span class="text-danger">*</span>
                    <select class="form-control" id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="owner">Owner</option>
                        <option value="karyawan">Karyawan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password</label><span class="text-danger">*</span>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label><span class="text-danger">*</span>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Select Gender</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nohp">No. Hp</label><span class="text-info"> (Opsional)</span>
                    <input type="text" class="form-control" id="nohp" name="nohp">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label><span class="text-info"> (Opsional)</span>
                    <textarea class="form-control" id="alamat" name="alamat"></textarea>
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label><span class="text-info"> (Opsional)</span>
                    <input type="file" class="form-control-file" id="foto" name="foto">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('editUserModal')">&times;</span>
            <h2>Edit Pengguna</h2>
            <form id="editUserForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_username">Username</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="edit_username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="edit_name">Nama Lengkap</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="edit_name" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="edit_email">Email</label><span class="text-danger">*</span>
                    <input type="email" class="form-control" id="edit_email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="edit_role">Role</label><span class="text-danger">*</span>
                    <select class="form-control" id="edit_role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="owner">Owner</option>
                        <option value="karyawan">Karyawan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_password">Password </label><span class="text-warning"> (Kosongkan Jika Tidak
                        Diubah)</span>
                    <input type="password" class="form-control" id="edit_password" name="password">
                </div>
                <div class="form-group">
                    <label for="edit_jenis_kelamin">Jenis Kelamin</label><span class="text-danger">*</span>
                    <select class="form-control" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Select Gender</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_nohp">No. Hp</label><span class="text-info"> (Opsional)</span>
                    <input type="text" class="form-control" id="edit_nohp" name="nohp">
                </div>
                <div class="form-group">
                    <label for="edit_alamat">Alamat</label><span class="text-info"> (Opsional)</span>
                    <textarea class="form-control" id="edit_alamat" name="alamat"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_foto">Foto</label><span class="text-info"> (Opsional)</span>
                    <input type="file" class="form-control-file" id="edit_foto" name="foto">
                    <img id="current_foto" src="" alt="Current Foto" class="img-thumbnail mt-2">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div id="deleteUserModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-btn" onclick="closeModal('deleteUserModal')">&times;</span>
            <h2>Konfirmasi Penghapusan</h2>
            <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteUserModal')">Batal</button>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        // Fungsi untuk menutup modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        // Fungsi untuk membuka modal hapus dan mengatur form action
        function openDeleteModal(userId) {
            var form = document.getElementById('deleteUserForm');
            form.action = `/admin/users/${userId}`;
            openModal('deleteUserModal');
        }

        // Fungsi untuk membuka modal edit dan mengisi data
        function openEditModal(id, username, nama, email, role, jenis_kelamin, nohp, alamat, foto) {
            console.log(foto); // Debugging - pastikan nama file benar

            document.getElementById('edit_username').value = username;
            document.getElementById('edit_name').value = nama;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
            document.getElementById('edit_nohp').value = nohp;
            document.getElementById('edit_alamat').value = alamat;

            if (foto) {
                document.getElementById('current_foto').src = `/${foto}`;

                document.getElementById('current_foto').style.display = 'block';
            } else {
                document.getElementById('current_foto').style.display = 'none';
            }

            // Update form action untuk edit
            document.getElementById('editUserForm').action = `/admin/users/${id}`;
            openModal('editUserModal');
        }
    </script>
@endsection
