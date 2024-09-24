@extends('layouts.karyawan')

@section('content')
    <div class="container">
        <h1 class="mb-4 mt-4">Tambah Absensi</h1>
        <hr>
        <form action="{{ route('karyawan.absensi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <button type="submit" class="btn btn-danger">Simpan</button>
            <br>
            <div class="form-group mb-3 mt-3">
                <label for="kehadiran" class="form-label">Kehadiran</label><span class="text-danger">*</span>
                <select id="kehadiran" name="kehadiran" class="form-control" required>
                    <option value="" disabled selected>Select Kehadiran</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                </select>
            </div>
            <!-- Deskripsi Input -->
            <div class="form-group mb-4">
                <label for="deskripsi" class="form-label">Deskripsi<span class="text-info"> (Opsional)</span></label>
                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="row mb-4">

                <div id="camera" class="mb-3" style="display:none;">
                    <video id="camera-stream" width="350" height="200" autoplay></video>
                    <button type="button" id="capture-photo" class="btn btn-primary mt-2">Capture Photo</button>
                    <canvas id="canvas" width="350" height="200" style="display:none;"></canvas>
                    <input type="hidden" name="foto" id="photo-input">
                </div>

                <!-- File Input -->
                <div id="file-input-group" class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label for="file" class="form-label">File<span class="text-info"> (Opsional)</span></label>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
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
            const cameraDiv = document.querySelector('#camera');
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

            // Show or hide camera and file input based on kehadiran selection
            kehadiranSelect.addEventListener('change', function() {
                if (kehadiranSelect.value === 'Hadir') {
                    cameraDiv.style.display = 'block';
                    fileInputGroup.style.display = 'none';
                } else {
                    cameraDiv.style.display = 'none';
                    fileInputGroup.style.display = 'block';
                    photoInput.value = ''; // Clear photo input if not present
                }
            });
        });
    </script>
@endsection
