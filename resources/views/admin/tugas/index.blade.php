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

        <h2 class="mb-4">Daftar Tugas</h2>
        <hr>

        <!-- Button to trigger create tugas modal -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createTugasModal">
            <i class="fas fa-plus"></i> Tambah Tugas
        </button>

        <!-- Tugas Table -->
        <div class="table-responsive">
            <table id="table-ok" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Kategori Pembuatan</th>
                        <th>Kategori Grade</th>
                        <th>Karyawan</th>
                        <th>Ukuran</th>
                        <th>Warna</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tugas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->barang->nama }}</td>
                            <td>{{ $item->kategori_pembuatan_id }}</td>
                            <td>{{ $item->kategori_grade_id }}</td>
                            <td>{{ $item->karyawan->nama }}</td>
                            <td>{{ $item->ukuran }}</td>
                            <td>{{ $item->warna }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm mb-2" data-toggle="modal"
                                    data-target="#editTugasModal" data-id="{{ $item->id }}"
                                    data-barang="{{ $item->barang_id }}"
                                    data-kategori-pembuatan="{{ $item->kategori_pembuatan_id }}"
                                    data-kategori-grade="{{ $item->kategori_grade_id }}"
                                    data-karyawan="{{ $item->karyawan_id }}" data-ukuran="{{ $item->ukuran }}"
                                    data-warna="{{ $item->warna }}" data-jumlah="{{ $item->jumlah }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteTugasModal"
                                    data-id="{{ $item->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Tugas Modal -->
    <div class="modal fade" id="createTugasModal" tabindex="-1" role="dialog" aria-labelledby="createTugasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTugasModalLabel">Tambah Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createTugasForm" action="{{ route('tugas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="barang_id">Barang</label>
                            <select id="barang_id" name="barang_id" class="form-control" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kategori_pembuatan_id">Kategori Pembuatan</label>
                            <input type="text" class="form-control" id="kategori_pembuatan_id"
                                name="kategori_pembuatan_id" required>
                        </div>
                        <div class="form-group">
                            <label for="kategori_grade_id">Kategori Grade</label>
                            <input type="text" class="form-control" id="kategori_grade_id" name="kategori_grade_id"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="karyawan_id">Karyawan</label>
                            <select id="karyawan_id" name="karyawan_id" class="form-control" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ukuran">Ukuran</label>
                            <input type="text" class="form-control" id="ukuran" name="ukuran" required>
                        </div>
                        <div class="form-group">
                            <label for="warna">Warna</label>
                            <input type="text" class="form-control" id="warna" name="warna" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tugas Modal -->
    <div class="modal fade" id="editTugasModal" tabindex="-1" role="dialog" aria-labelledby="editTugasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTugasModalLabel">Edit Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editTugasForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_barang_id">Barang</label>
                            <select id="edit_barang_id" name="barang_id" class="form-control" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_kategori_pembuatan_id">Kategori Pembuatan</label>
                            <input type="text" class="form-control" id="edit_kategori_pembuatan_id"
                                name="kategori_pembuatan_id" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_kategori_grade_id">Kategori Grade</label>
                            <input type="text" class="form-control" id="edit_kategori_grade_id"
                                name="kategori_grade_id" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_karyawan_id">Karyawan</label>
                            <select id="edit_karyawan_id" name="karyawan_id" class="form-control" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_ukuran">Ukuran</label>
                            <input type="text" class="form-control" id="edit_ukuran" name="ukuran" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_warna">Warna</label>
                            <input type="text" class="form-control" id="edit_warna" name="warna" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="edit_jumlah" name="jumlah" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Tugas Modal -->
    <div class="modal fade" id="deleteTugasModal" tabindex="-1" role="dialog" aria-labelledby="deleteTugasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTugasModalLabel">Hapus Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteTugasForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus tugas ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle Edit Tugas
            $('#editTugasModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                var barang_id = button.data('barang');
                var kategori_pembuatan_id = button.data('kategori-pembuatan');
                var kategori_grade_id = button.data('kategori-grade');
                var karyawan_id = button.data('karyawan');
                var ukuran = button.data('ukuran');
                var warna = button.data('warna');
                var jumlah = button.data('jumlah');

                var modal = $(this);
                modal.find('#edit_barang_id').val(barang_id);
                modal.find('#edit_kategori_pembuatan_id').val(kategori_pembuatan_id);
                modal.find('#edit_kategori_grade_id').val(kategori_grade_id);
                modal.find('#edit_karyawan_id').val(karyawan_id);
                modal.find('#edit_ukuran').val(ukuran);
                modal.find('#edit_warna').val(warna);
                modal.find('#edit_jumlah').val(jumlah);

                var action = '{{ route('tugas.update', ':id') }}';
                action = action.replace(':id', id);
                modal.find('#editTugasForm').attr('action', action);
            });

            // Handle Delete Tugas
            $('#deleteTugasModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes

                var modal = $(this);
                var action = '{{ route('tugas.destroy', ':id') }}';
                action = action.replace(':id', id);
                modal.find('#deleteTugasForm').attr('action', action);
            });
        });
    </script>
@endpush