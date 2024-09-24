@extends('layouts.karyawan')

@section('content')
    <div class="container">
        <h1 class="mb-4 mt-4">Edit Absensi</h1>
        <hr>
        <form action="{{ route('karyawan.absensi.update', $absensi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger mb-4">Update</button>
            <div class="form-group">
                <label for="kehadiran">Kehadiran</label><span class="text-danger">*</span>
                <select id="kehadiran" name="kehadiran" class="form-control" required>
                    <option value="Hadir" {{ $absensi->kehadiran == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Izin" {{ $absensi->kehadiran == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Sakit" {{ $absensi->kehadiran == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi<span class="text-info"> (Opsional)</span></label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $absensi->deskripsi) }}</textarea>
            </div>

            <!-- Camera Stream and Capture Button -->
            <div id="camera" class="mb-3" style="{{ $absensi->kehadiran == 'Hadir' ? '' : 'display:none;' }}">
                <video id="camera-stream" width="350" height="200" autoplay></video>
                <button type="button" id="capture-photo" class="btn btn-primary mt-2">Capture Photo</button>
                <canvas id="canvas" width="350" height="200" style="display:none;"></canvas>
                <input type="hidden" name="foto" id="photo-input" value="{{ old('foto', $absensi->foto) }}">
                {{-- @if ($absensi->foto)
                    <img src="{{ asset($absensi->foto) }}" alt="Current Foto" class="img-thumbnail mt-2" width="100">
                @endif --}}
            </div>

            <div id="file-input-group" class="form-group"
                style="{{ $absensi->kehadiran == 'Hadir' ? 'display:none;' : '' }}">
                <label for="file">File<span class="text-info"> (Opsional)</span></label>
                <input type="file" name="file" class="form-control">
                {{-- @if ($absensi->file)
                    <a href="{{ asset('public/absensi_files/' . $absensi->file) }}" target="_blank">Lihat
                        File</a>
                @endif --}}
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.querySelector('#camera-stream');
            const captureButton = document.querySelector('#capture-photo');
            const canvas = document.querySelector('#canvas');
            const photoInput = document.querySelector('#photo-input');
            const kehadiranSelect = document.querySelector('#kehadiran');
            const fileInputGroup = document.querySelector('#file-input-group');

            // Request access to the user's camera
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then((stream) => {
                    video.srcObject = stream;
                    video.play();
                })
                .catch((err) => {
                    console.error("Error accessing the camera: " + err);
                });

            // Capture the photo when the button is clicked
            captureButton.addEventListener('click', function() {
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const dataURL = canvas.toDataURL('image/png');
                photoInput.value = dataURL;
                alert('Photo captured successfully!');
            });

            // Enable or disable camera and file input based on kehadiran selection
            kehadiranSelect.addEventListener('change', function() {
                if (kehadiranSelect.value === 'Hadir') {
                    document.querySelector('#camera').style.display = 'block';
                    fileInputGroup.style.display = 'none';
                } else {
                    document.querySelector('#camera').style.display = 'none';
                    fileInputGroup.style.display = 'block';
                    photoInput.value = ''; // Clear photo input if not present
                }
            });

            // Set initial camera and file input visibility based on existing value
            if (kehadiranSelect.value === 'Hadir') {
                document.querySelector('#camera').style.display = 'block';
                fileInputGroup.style.display = 'none';
            } else {
                document.querySelector('#camera').style.display = 'none';
                fileInputGroup.style.display = 'block';
            }
        });
    </script>
@endsection
